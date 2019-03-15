FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client \
    && docker-php-ext-install mcrypt pdo_mysql # cài một số package cần thiết

ADD ./php.conf /usr/local/etc/php-fpm.conf # Config PHP
COPY ./php.ini /usr/local/etc/php/ # Config PHP

ADD ./src /var/www/blog
RUN chown www-data:www-data -R /var/www/blog

RUN apt-get install net-tools -y

WORKDIR /var/www/blog
