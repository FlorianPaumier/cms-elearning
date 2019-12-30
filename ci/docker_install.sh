#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install apt-utils -yqq
apt-get install git postgresql libzip-dev zlib1g-dev libpq-dev -yqq

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install pdo mysqli pdo_mysql pdo_pgsql

apt-get install -y libpng-dev libfreetype6-dev libyaml-dev

pecl install yaml-2.0.0 && docker-php-ext-enable yaml

# Install phpunit, the tool that we will use for testing
curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
chmod +x /usr/local/bin/phpunit

docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 && docker-php-ext-install gd
