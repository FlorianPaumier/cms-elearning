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

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && php composer-setup.php --filename=composer && php -r "unlink('composer-setup.php');" && mv composer /usr/local/bin/composer
cd www && composer install --dev