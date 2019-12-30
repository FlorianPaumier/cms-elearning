#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git -yqq
apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libyaml-dev

pecl install yaml-2.0.0 && docker-php-ext-enable yaml

# Install phpunit, the tool that we will use for testing
curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
chmod +x /usr/local/bin/phpunit

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install pdo_mysql
docker-php-ext-install pdo_pgsql
docker-php-ext-install gd

docker-php-ext-install zip
docker-php-ext-enable apcu