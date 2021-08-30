FROM php:7.4-fpm
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN mkdir /app
WORKDIR /app
COPY . /app/