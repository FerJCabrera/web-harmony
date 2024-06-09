# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido del proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install

# Exponer el puerto 80
EXPOSE 80

# Comando para ejecutar el servidor
CMD ["apache2-foreground"]
