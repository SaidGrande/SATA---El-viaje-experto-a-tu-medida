FROM php:8.2-apache

# Instalar Perl
RUN apt-get update && apt-get install -y perl

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar tu proyecto al servidor
COPY . /var/www/html/

# Dar permisos
RUN chmod -R 755 /var/www/html

# Setear DocumentRoot
WORKDIR /var/www/html
