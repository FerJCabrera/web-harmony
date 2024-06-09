# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido del proyecto al contenedor
COPY . .

# Exponer el puerto 80
EXPOSE 80

# Comando para ejecutar el servidor
CMD ["apache2-foreground"]
