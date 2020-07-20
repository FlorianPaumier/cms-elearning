FROM php:7.2.0-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    libpq-dev

RUN docker-php-ext-install pdo mysqli pdo_mysql pdo_pgsql

RUN apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libyaml-dev

RUN pecl install yaml-2.0.0 && docker-php-ext-enable yaml

RUN docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-install gd

RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu

WORKDIR /app

RUN PATH=$PATH:/app/vendor/bin:bin
#RUN a2enmod yaml