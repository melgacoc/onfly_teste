FROM php:8.2-apache

RUN apt-get update && apt-get install -y zip unzip git

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

EXPOSE 80
