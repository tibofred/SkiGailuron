# ========= Build stage: PHP + deps =========
FROM php:7.3-fpm-alpine AS build

RUN apk add --no-cache bash git curl icu-dev oniguruma-dev libzip-dev zlib-dev autoconf make g++ \
    && docker-php-ext-install intl pdo_mysql zip opcache mbstring \
    && pecl install apcu \
    && docker-php-ext-enable apcu

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction \
 && mkdir -p var/cache var/logs var/sessions \
 && chown -R www-data:www-data var

# ========= Runtime stage =========
FROM alpine:3.19

RUN apk add --no-cache nginx supervisor bash \
 && mkdir -p /run/nginx /var/log/nginx

# PHP (copié du stage build)
COPY --from=build /usr/local /usr/local
COPY --from=build /app /app

# Supervisord conf (statique)
RUN printf '%s\n' \
  '[supervisord]' \
  'nodaemon=true' \
  '' \
  '[program:php-fpm]' \
  'command=/usr/local/sbin/php-fpm -F' \
  'autorestart=true' \
  'priority=10' \
  '' \
  '[program:nginx]' \
  'command=/usr/sbin/nginx -g "daemon off;"' \
  'autorestart=true' \
  'priority=20' \
  > /etc/supervisord.conf

# ENTRYPOINT: on génère nginx.conf avec la vraie valeur $PORT au runtime
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

WORKDIR /app
ENV APP_ENV=prod PORT=8080
EXPOSE 8080

EXPOSE 8080
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
