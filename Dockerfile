# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el contenido del proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install

# Configura ServerName para evitar advertencias
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer el puerto 80
EXPOSE 80

# Añade esto antes del CMD
RUN apt-get install -y net-tools
CMD netstat -an | grep 80


# Comando para ejecutar el servidor
CMD ["apache2-foreground"]
