# ========= Build stage: PHP + deps =========
FROM php:7.3-fpm-alpine AS build

# Outils & libs nécessaires pour compiler les extensions PHP
RUN apk add --no-cache \
      bash git curl \
      icu-dev oniguruma-dev libzip-dev zlib-dev libxml2-dev autoconf make g++

# Extensions PHP utiles à Symfony 3.4
RUN docker-php-ext-install intl pdo_mysql zip opcache mbstring \
 && pecl install apcu \
 && docker-php-ext-enable apcu

# Composer (v2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Code source
WORKDIR /app
COPY . /app

# Install Composer (prod)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# Dossiers d'écriture Symfony 3.4
RUN mkdir -p var/cache var/logs var/sessions \
 && chown -R www-data:www-data var

# ========= Runtime stage =========
FROM php:7.3-fpm-alpine

# Paquets runtime + Nginx + Supervisor
RUN apk add --no-cache \
      nginx supervisor bash \
      icu-libs libzip libxml2 oniguruma zlib tzdata curl \
 && mkdir -p /run/nginx /var/log/nginx

# Copie de l'app (vendor déjà installé)
COPY --from=build /app /app

# Supervisord: lance php-fpm + nginx
RUN printf '%s\n' \
  '[supervisord]' \
  'nodaemon=true' \
  '' \
  '[program:php-fpm]' \
  'command=/usr/local/sbin/php-fpm -F' \
  'user=root' \
  'autorestart=true' \
  'priority=10' \
  '' \
  '[program:nginx]' \
  'command=/usr/sbin/nginx -g "daemon off;"' \
  'user=root' \
  'autorestart=true' \
  'priority=20' \
  > /etc/supervisord.conf

# Entrypoint: génère nginx.conf au runtime (utilise $PORT fourni par Kinsta)
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

WORKDIR /app
ENV APP_ENV=prod
ENV PORT=8080

EXPOSE 8080
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
