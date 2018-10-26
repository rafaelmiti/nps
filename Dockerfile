FROM php:latest

RUN apt-get update \
  && apt-get install -y \
     libmemcached11 \
     libmemcachedutil2 \
     build-essential \
     libmemcached-dev \
     libz-dev \
     git \
  && git clone -b php7 https://github.com/php-memcached-dev/php-memcached.git /usr/src/php/ext/memcached \
  && cd /usr/src/php/ext/memcached \
  && phpize \
  && ./configure \
  && make all \
  && docker-php-ext-install memcached \
  && docker-php-ext-enable memcached

RUN docker-php-ext-install mysqli pdo pdo_mysql
