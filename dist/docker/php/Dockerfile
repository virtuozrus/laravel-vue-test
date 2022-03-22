FROM php:7.2-fpm

WORKDIR /fulltest

#RUN printf "deb http://archive.debian.org/debian/ jessie main\ndeb-src http://archive.debian.org/debian/ jessie main\ndeb http://security.debian.org jessie/updates main\ndeb-src http://security.debian.org jessie/updates main" > /etc/apt/sources.list

RUN apt-get -y dist-upgrade
RUN apt-get update -y --fix-missing
RUN apt-get update


RUN apt-get install -y \
        nano \
        git \
        zip \
        bash-completion \
        libyaml-dev \
        libpng-dev


RUN docker-php-ext-install pdo pdo_mysql gd bcmath

RUN pecl install -o -f apcu yaml psr \
    && rm -rf /tmp/pear \
    && echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini \
    && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/yaml.ini \
    && echo "extension=psr.so" > /usr/local/etc/php/conf.d/0_psr.ini
