#!/bin/bash
set -e

# Reemplazar el puerto en la configuración de Apache
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-available/000-default.conf

# Crear directorios necesarios si no existen
mkdir -p /var/www/html/src/temp /var/www/html/src/php
chmod -R 777 /var/www/html/src/temp /var/www/html/src/php

# Iniciar Apache en primer plano
echo "Iniciando Apache en puerto ${PORT:-80}..."
apache2ctl -D FOREGROUND