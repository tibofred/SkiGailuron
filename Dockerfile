# ========= Build stage: PHP + deps =========
FROM php:7.3-fpm-alpine AS build

# Paquets & extensions PHP nécessaires à Symfony 3.4 et à tes deps
RUN apk add --no-cache \
      bash git curl icu-dev oniguruma-dev libzip-dev zlib-dev autoconf make g++ \
    && docker-php-ext-install intl pdo_mysql zip opcache mbstring \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Composer (v2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Code source
WORKDIR /app
# On copie tout pour permettre l'exécution des scripts post-install (assets, cache)
COPY . /app

# Optimiser Composer (prod)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install \
      --no-dev --prefer-dist --optimize-autoloader --no-interaction

# Ajuste les droits pour Symfony 3.4
RUN mkdir -p var/cache var/logs var/sessions \
    && chown -R www-data:www-data var

# ========= Runtime stage: Nginx + PHP-FPM =========
FROM alpine:3.19

# Nginx, Supervisor et utilitaires
RUN apk add --no-cache nginx supervisor bash \
    && mkdir -p /run/nginx /var/log/nginx

# Copie des binaires et librairies PHP du stage build
COPY --from=build /usr/local /usr/local
COPY --from=build /app /app

# NGINX: config auto-écrite (écoute sur $PORT requis par Kinsta)
RUN printf '%s\n' \
  'user  nginx;' \
  'worker_processes auto;' \
  'events { worker_connections 1024; }' \
  'http {' \
  '  include       /etc/nginx/mime.types;' \
  '  default_type  application/octet-stream;' \
  '  sendfile on;' \
  '  keepalive_timeout 65;' \
  '  server {' \
  '    listen       ${PORT};' \
  '    server_name  _;' \
  '    root   /app/web;' \
  '    index  app.php index.php;' \
  '    location / {' \
  '      try_files $uri /app.php$is_args$args;' \
  '    }' \
  '    location ~ \.php$ {' \
  '      include fastcgi_params;' \
  '      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;' \
  '      fastcgi_pass 127.0.0.1:9000;' \
  '      fastcgi_read_timeout 300;' \
  '    }' \
  '    location ~* \.(?:css|js|jpg|jpeg|gif|png|svg|ico|woff2?)$ {' \
  '      try_files $uri =404;' \
  '      access_log off;' \
  '      expires max;' \
  '    }' \
  '  }' \
  '}' \
  > /etc/nginx/nginx.conf

# Supervisor: lance PHP-FPM + Nginx
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

WORKDIR /app

# Variables d'env classiques Symfony 3.4
ENV APP_ENV=prod
# Kinsta injecte PORT au runtime; default utile en local:
ENV PORT=8080

EXPOSE 8080

# Dossier public Symfony 3.4 = /app/web (déjà configuré dans nginx.conf)
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
