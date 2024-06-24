FROM php:8.2-apache

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions gd zip sodium pdo pdo_mysql @composer-2.6.4

RUN apt update && apt install -y nodejs npm

COPY --chown=www-data:www-data . /var/www/

COPY ./docker_sorh/apache.conf /etc/apache2/sites-available/000-default.conf

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN cd /var/www/ && \
    composer install && \
    npm install --force && \
    composer require symfony/webpack-encore-bundle && \
    composer require symfony/dotenv && \
    npm run build

USER www-data

WORKDIR /var/www

EXPOSE 80