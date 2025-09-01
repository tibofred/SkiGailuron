# ========= Build stage: PHP + Composer + extensions =========
FROM php:7.3-fpm-alpine AS build

# Outils & libs nécessaires pour compiler les extensions PHP
RUN set -eux; \
    apk add --no-cache \
      bash git curl unzip \
      icu-dev oniguruma-dev libzip-dev zlib-dev libxml2-dev autoconf make g++ \
      libpng-dev libjpeg-turbo-dev freetype-dev;

# GD pour PHP 7.3 -> utiliser --with-freetype-dir et --with-jpeg-dir
RUN set -eux; \
    docker-php-ext-configure gd \
      --with-freetype-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j"$(nproc)" \
      intl pdo_mysql zip opcache mbstring gd; \
    pecl install apcu; \
    docker-php-ext-enable apcu

# Composer (v2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier applicatif
WORKDIR /app

# Installer vendor avec cache Docker
COPY composer.json composer.lock ./
RUN set -eux; \
    composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts

# Copier le reste du code
COPY . .

# Scripts post-install (si nécessaires)
RUN set -eux; composer dump-autoload --optimize

# ========= Runtime stage: PHP-FPM + Nginx + Supervisor =========
FROM php:7.3-fpm-alpine AS runtime

# Paquets runtime + Nginx + Supervisor
RUN set -eux; \
    apk add --no-cache \
      bash curl nginx supervisor \
      icu-libs libzip zlib libxml2 \
      libpng libjpeg-turbo freetype; \
    mkdir -p /run/nginx /var/log/supervisor

# Copier extensions et conf PHP compilées
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Tuning PHP-FPM (optionnel)
RUN set -eux; \
    { \
      echo "memory_limit=512M"; \
      echo "opcache.enable=1"; \
      echo "opcache.enable_cli=0"; \
      echo "opcache.validate_timestamps=0"; \
      echo "cgi.fix_pathinfo=0"; \
    } > /usr/local/etc/php/conf.d/z-custom.ini

# Copier l’app (vendor déjà présent)
WORKDIR /app
COPY --from=build /app /app

# Droits
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

# EntryPoint: génère nginx.conf au runtime (utilise $PORT fourni par Kinsta)
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

ENV APP_ENV=prod
ENV PORT=8080
EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
