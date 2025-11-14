# ============================================
# ARCHIVO 2: Dockerfile (VERSIÓN MEJORADA)
# ============================================
# Usar Ubuntu como base
FROM ubuntu:22.04

# Evitar prompts interactivos durante instalación
ENV DEBIAN_FRONTEND=noninteractive
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data
ENV APACHE_LOG_DIR=/var/log/apache2

# Instalar dependencias básicas
RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    libapache2-mod-php \
    php-cli \
    software-properties-common \
    wget \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Instalar SWI-Prolog
RUN apt-get update && \
    apt-add-repository ppa:swi-prolog/stable -y && \
    apt-get update && \
    apt-get install -y swi-prolog && \
    rm -rf /var/lib/apt/lists/*

# Configurar Apache
RUN a2enmod rewrite
RUN a2enmod php8.1

# Copiar archivos del proyecto
COPY . /var/www/html/

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    mkdir -p /var/www/html/src/temp /var/www/html/src/php && \
    chmod -R 777 /var/www/html/src/temp && \
    chmod -R 777 /var/www/html/src/php

# Habilitar exec() en PHP
RUN sed -i 's/disable_functions = .*/disable_functions = /' /etc/php/8.1/apache2/php.ini

# Crear directorio de logs si no existe
RUN mkdir -p /var/log/apache2 && \
    chown -R www-data:www-data /var/log/apache2

# Copiar script de inicio
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exponer el puerto (Render lo asignará dinámicamente)
EXPOSE ${PORT:-80}

# Comando de inicio
CMD ["/usr/local/bin/docker-entrypoint.sh"]
