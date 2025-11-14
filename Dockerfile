# Usar Ubuntu como base
FROM ubuntu:22.04

# Evitar prompts interactivos durante instalación
ENV DEBIAN_FRONTEND=noninteractive

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    libapache2-mod-php \
    php-cli \
    software-properties-common \
    wget \
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

# Configurar Apache para escuchar en el puerto que Render asigna
RUN sed -i 's/Listen 80/Listen ${PORT:-80}/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT:-80}/' /etc/apache2/sites-available/000-default.conf

# Exponer el puerto
EXPOSE ${PORT:-80}

# Script de inicio personalizado
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Comando de inicio
CMD ["/usr/local/bin/docker-entrypoint.sh"]