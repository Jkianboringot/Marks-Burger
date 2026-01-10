FROM php:8.3-fpm

COPY . /MARKSBURGER

WORKDIR /MARKSBURGER

COPY composer.json composer.lock ./


RUN apt-get update && apt-get install -y git unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && composer install


COPY . .