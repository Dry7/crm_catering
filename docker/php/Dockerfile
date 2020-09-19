FROM php:7.0-fpm-alpine3.7

RUN apk add --no-cache $PHPIZE_DEPS mysql libxml2-dev \
    && apk add --no-cache libpq icu-dev libzip-dev \
    && pecl install xdebug-2.9.0 redis \
    && docker-php-ext-install pdo_mysql mysqli xml intl zip \
    && docker-php-ext-enable xdebug redis \
    && apk add --no-cache freetype-dev libpng libpng-dev jpeg-dev libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) gd && apk del libpng-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer

COPY ./ini/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./ini/php.ini /usr/local/etc/php/conf.d/docker-php.ini

RUN addgroup -S catering && adduser -S catering -G catering -u 1000

USER catering
