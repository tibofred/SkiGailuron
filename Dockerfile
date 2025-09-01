# ========= Build stage: PHP + Composer + extensions =========
FROM php:7.3-fpm-alpine AS build

# Outils & libs pour compiler extensions PHP + utilitaires Composer
RUN set -eux; \
    apk add --no-cache \
      bash curl unzip git openssh-client ca-certificates \
      icu-dev oniguruma-dev libzip-dev zlib-dev libxml2-dev \
      autoconf make g++ libpng-dev libjpeg-turbo-dev freetype-dev; \
    update-ca-certificates

# GD pour PHP 7.3 -> flags legacy
RUN set -eux; \
    docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j"$(nproc)" \
      intl pdo_mysql zip opcache mbstring gd; \
    pecl install apcu; \
    docker-php-ext-enable apcu

# Composer 2.2 LTS (compatible PHP 7.3)
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_DISABLE_XDEBUG_WARN=1 \
    COMPOSER_NO_INTERACTION=1

# Build args pour contrôler le comportement Composer
# - PIN_PLATFORM=1 => "platform.php = 7.3.0" (par défaut)
# - IGNORE_PLATFORM_REQS=0 => ne PAS ignorer les contraintes (par défaut)
ARG PIN_PLATFORM=1
ARG IGNORE_PLATFORM_REQS=0

WORKDIR /app

# Copier uniquement les manifestes pour utiliser le cache Docker
COPY composer.json composer.lock ./

# Diagnostics Composer & plateforme
RUN set -eux; \
    composer --version; \
    php -v; \
    php -m | sort; \
    composer validate --no-check-publish -n || true; \
    if [ "$PIN_PLATFORM" = "1" ]; then \
      composer config platform.php 7.3.0; \
      echo 'Pinned Composer platform.php=7.3.0'; \
    fi; \
    composer check-platform-reqs -v || true

# (Option) Token pour dépôts privés (décommente si nécessaire)
# COPY auth.json /root/.composer/auth.json

# 1) Installation SANS plugins ni scripts (diagnostic)
RUN set -eux; \
    if [ "$IGNORE_PLATFORM_REQS" = "1" ]; then \
      composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts --no-plugins -vvv --ignore-platform-reqs || { echo '== NO-PLUGINS INSTALL FAILED =='; exit 1; }; \
    else \
      composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts --no-plugins -vvv || { echo '== NO-PLUGINS INSTALL FAILED =='; exit 1; }; \
    fi

# 2) Installation AVEC plugins (Flex, etc.)
RUN set -eux; \
    if [ "$IGNORE_PLATFORM_REQS" = "1" ]; then \
      composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts -vvv --ignore-platform-reqs || { echo '== WITH-PLUGINS INSTALL FAILED =='; exit 1; }; \
    else \
      composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts -vvv || { echo '== WITH-PLUGINS INSTALL FAILED =='; exit 1; }; \
    fi

# Copier le reste du code applicatif
COPY . .

# Autoload optimisé
RUN set -eux; composer dump-autoload --optimize

# ========= Runtime stage: PHP-FPM + Nginx + Supervisor =========
FROM php:7.3-fpm-alpine AS runtime

# Paquets runtime + Nginx + Supervisor
RUN set -eux; \
    apk add --no-cache \
      bash curl nginx supervisor ca-certificates \
      icu-libs libzip zlib libxml2 \
      libpng libjpeg-turbo freetype; \
    update-ca-certificates; \
    mkdir -p /run/nginx /var/log/supervisor

# Copier extensions et conf PHP compilées
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Tuning PHP-FPM
RUN set -eux; \
    { \
      echo "memory_limit=512M"; \
      echo "opcache.enable=1"; \
      echo "opcache.enable_cli=0"; \
      echo "opcache.validate_timestamps=0"; \
      echo "cgi.fix_pathinfo=0"; \
    } > /usr/local/etc/php/conf.d/z-custom.ini

# Copier l’application (vendor déjà présent)
WORKDIR /app
COPY --from=build /app /app

# Permissions var/
RUN set -eux; \
    chown -R www-data:www-data /app; \
    mkdir -p /app/var/cache /app/var/logs /app/var/sessions; \
    chown -R www-data:www-data /app/var

# Supervisor: lancer php-fpm + nginx
RUN set -eux; \
  printf "%s\n" \
  "[supervisord]" \
  "nodaemon=true" \
  "" \
  "[program:php-fpm]" \
  "command=/usr/local/sbin/php-fpm --nodaemonize" \
  "autostart=true" \
  "autorestart=true" \
  "priority=10" \
  "" \
  "[program:nginx]" \
  "command=/usr/sbin/nginx -g 'daemon off;'" \
  "autostart=true" \
  "autorestart=true" \
  "priority=20" \
  > /etc/supervisord.conf

# Entrypoint: génère nginx.conf au runtime (root web/, rewrite vers app.php, $PORT Kinsta)
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

ENV APP_ENV=prod
ENV PORT=8080
EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
