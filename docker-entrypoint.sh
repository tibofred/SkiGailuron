#!/usr/bin/env bash
set -e

# Valeur par défaut si non fournie (utile en local)
PORT="${PORT:-8080}"

cat > /etc/nginx/nginx.conf <<EOF
user  nginx;
worker_processes auto;

events { worker_connections 1024; }

http {
  include       /etc/nginx/mime.types;
  default_type  application/octet-stream;
  sendfile on;
  keepalive_timeout 65;

  server {
    listen       ${PORT};
    server_name  _;

    root   /app/web;     # Symfony 3.4: front-controller dans /web/app.php
    index  app.php index.php;

    location / {
      try_files \$uri /app.php\$is_args\$args;
    }

    location ~ \.php\$ {
      include fastcgi_params;
      fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
      fastcgi_pass 127.0.0.1:9000;
      fastcgi_read_timeout 300;
    }

    location ~* \.(?:css|js|jpg|jpeg|gif|png|svg|ico|woff2?)\$ {
      try_files \$uri =404;
      access_log off;
      expires max;
    }
  }
}
EOF

exec "$@"
