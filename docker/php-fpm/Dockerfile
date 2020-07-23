# Docker file for php-fpm
# 2019-07-10 - v1 - James Kerslake
# 2020-05-15 - v1.1 - Myro Stadler - add args instead of hardcoded xdebug settings

FROM php:7.3-fpm

ARG XDEBUG_IDEKEY
ARG XDEBUG_REMOTE_HOST
ARG XDEBUG_REMOTE_PORT

# install required modules
RUN echo "deb http://ftp.uk.debian.org/debian/ stable main contrib non-free" > /etc/apt/sources.list
RUN apt-get update -yq \
    && apt-get install -y zip libzip-dev libpng-dev libxml2-dev \
    && pecl -q install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install pdo pdo_mysql bcmath gd zip soap

# install composer globally
RUN curl -sSL https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# update ini file for xdebug using phpstorm
RUN echo "xdebug.remote_enable = 1" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart = 1" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = \"${XDEBUG_IDEKEY}\"" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host = ${XDEBUG_REMOTE_HOST}" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port = ${XDEBUG_REMOTE_PORT}" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

