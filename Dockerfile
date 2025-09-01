# ========= Build stage (compile extensions + vendor) =========
FROM php:7.3-fpm-alpine AS build

# Outils/headers nécessaires à certaines extensions
RUN set -eux; \
    apk add --no-cache bash git curl icu-dev oniguruma-dev libzip-dev zlib-dev libxml2-dev autoconf make g++

# Extensions PHP utiles (inclut pdo_mysql)
RUN set -eux; \
    docker-php-ext-install intl pdo_mysql zip opcache mbstring; \
    pecl install apcu; \
    docker-php-ext-enable apcu pdo_mysql

# Composer (v2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# (Optionnel) installe tes vendors ici si tu veux profiter du cache :
# WORKDIR /app
# COPY composer.json composer.lock ./
# RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts
# COPY . .
# RUN composer dump-autoload --optimize

# ========= Runtime stage (ce qui tourne réellement) =========
FROM php:7.3-fpm-alpine AS runtime

# Paquets runtime + nginx + supervisor
RUN set -eux; \
    apk add --no-cache bash curl nginx supervisor icu-libs libzip zlib libxml2; \
    mkdir -p /run/nginx /var/log/supervisor

# ⚠️ COPIER extensions + conf.d depuis le build (sinon pdo_mysql sera absent)
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# (Optionnel) petit tuning PHP
RUN set -eux; \
    { \
      echo "memory_limit=512M"; \
      echo "opcache.enable=1"; \
      echo "opcache.enable_cli=0"; \
      echo "opcache.validate_timestamps=0"; \
      echo "cgi.fix_pathinfo=0"; \
    } > /usr/local/etc/php/conf.d/z-custom.ini

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

# Entrypoint (génère nginx.conf selon $PORT)
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# Code de l’app
WORKDIR /app
COPY . .

ENV APP_ENV=prod
ENV PORT=8080
EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
