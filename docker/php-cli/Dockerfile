FROM php:8.1-cli-alpine
ENV XDEBUG_VERSION 3.2.0

RUN apk add --update linux-headers
RUN apk add bash coreutils git
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install xdebug

RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl

RUN apk add --no-cache unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app
