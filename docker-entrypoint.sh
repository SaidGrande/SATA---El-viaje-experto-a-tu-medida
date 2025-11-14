#!/bin/bash
set -e

PORT=${PORT:-80}

echo "Configurando Apache para puerto $PORT..."

cat > /etc/apache2/ports.conf << EOF
Listen $PORT

<IfModule ssl_module>
    Listen 443
</IfModule>

<IfModule mod_gnutls.c>
    Listen 443
</IfModule>
EOF

cat > /etc/apache2/sites-available/000-default.conf << EOF
<VirtualHost *:$PORT>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

mkdir -p /var/www/html/src/temp /var/www/html/src/php
chmod -R 777 /var/www/html/src/temp /var/www/html/src/php

echo "Iniciando Apache en puerto $PORT..."
apache2ctl -D FOREGROUND
