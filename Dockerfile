# ========= Build stage: PHP + Composer + extensions =========
FROM php:7.3-fpm-alpine AS build

# Outils & libs nécessaires pour compiler les extensions PHP
RUN apk add --no-cache \
      bash git curl unzip \
      icu-dev oniguruma-dev libzip-dev zlib-dev libxml2-dev autoconf make g++ \
      libpng-dev libjpeg-turbo-dev freetype-dev

# Extensions PHP utiles à Symfony 3.4
# - pdo_mysql : corrige "could not find driver"
# - intl, zip, opcache, mbstring : classiques pour Symfony
# - gd (optionnel si tu manipules des images)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) intl pdo_mysql zip opcache mbstring gd \
 && pecl install apcu \
 && docker-php-ext-enable apcu

# Composer (v2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier applicatif
WORKDIR /app

# Copie du code avant l'installation pour profiter du cache Docker sur vendor
COPY composer.json composer.lock ./

# Installer les dépendances en mode prod (pas de dev)
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts

# Ensuite on copie le reste du code
COPY . .

# Lancer les scripts post-install maintenant (si nécessaires)
RUN composer dump-autoload --optimize

# ========= Runtime stage: PHP-FPM + Nginx + Supervisor =========
FROM php:7.3-fpm-alpine AS runtime

# Paquets nécessaires au runtime, Nginx et Supervisor
RUN apk add --no-cache \
      bash curl nginx supervisor \
      icu-libs libzip zlib libxml2 \
      libpng libjpeg-turbo freetype

# Copier les extensions et conf PHP compilées dans l'étape build
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
# Copier apcu.ini si nécessaire (généralement dans conf.d depuis pecl)
# (Déjà récupéré via la ligne ci-dessus)

# PHP-FPM tuning (optionnel)
RUN { \
      echo "memory_limit=512M"; \
      echo "opcache.enable=1"; \
      echo "opcache.enable_cli=0"; \
      echo "opcache.validate_timestamps=0"; \
      echo "cgi.fix_pathinfo=0"; \
    } > /usr/local/etc/php/conf.d/z-custom.ini

# Nginx configuration directories
RUN mkdir -p /run/nginx /var/log/supervisor

# Copier le code de l’app (depuis l’étape build où vendor est déjà installé)
WORKDIR /app
COPY --from=build /app /app

# Droits (selon besoin)
RUN chown -R www-data:www-data /app \
 && mkdir -p /app/var/cache /app/var/logs /app/var/sessions \
 && chown -R www-data:www-data /app/var

# ---------------- Supervisor config: lancer php-fpm + nginx ----------------
RUN printf "%s\n" \
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

# ---------------- EntryPoint: génère nginx.conf au runtime ----------------
# (Ce script doit exister dans ton repo ; il utilise $PORT fourni par Kinsta
#  pour créer un nginx.conf qui écoute sur ce port et reverse-proxy vers php-fpm.)
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# Environnement
ENV APP_ENV=prod
ENV PORT=8080

# Exposer le port attendu par Kinsta
EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisord.conf"]
