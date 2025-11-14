# ============================================
# ARCHIVO 1: docker-entrypoint.sh
# ============================================
#!/bin/bash
set -e

# Obtener el puerto o usar 80 por defecto
PORT=${PORT:-80}

echo "Configurando Apache para puerto $PORT..."

# Configurar puerto en ports.conf
cat > /etc/apache2/ports.conf << EOF
Listen $PORT

<IfModule ssl_module>
    Listen 443
</IfModule>

<IfModule mod_gnutls.c>
    Listen 443
</IfModule>
EOF

# Configurar puerto en el VirtualHost
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

# Crear directorios necesarios si no existen
mkdir -p /var/www/html/src/temp /var/www/html/src/php
chmod -R 777 /var/www/html/src/temp /var/www/html/src/php

# Verificar que SWI-Prolog funciona
echo "Verificando SWI-Prolog..."
swipl --version || echo "Advertencia: SWI-Prolog no encontrado"

# Verificar que PHP funciona
echo "Verificando PHP..."
php -v || echo "Advertencia: PHP no encontrado"

echo "Iniciando Apache en puerto $PORT..."
apache2ctl -D FOREGROUND

