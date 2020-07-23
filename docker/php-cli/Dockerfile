# Dockerfile for php-cli
# 2019-07-10 - v1 - James K
# 2019-08-13 - v1.1 - James K - adds settings for mailhog
FROM php:7.3

# install php modules
RUN echo "deb http://ftp.uk.debian.org/debian/ stable main contrib non-free" > /etc/apt/sources.list
RUN apt-get update -yq \
    && apt-get install -yq --fix-missing libxslt1-dev zip libzip-dev libpng-dev libxml2-dev git graphviz wget\
    && docker-php-ext-configure zip --with-libzip \
    && pecl -q install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install xsl pdo pdo_mysql bcmath gd zip soap

# install composer globally
RUN curl -sSL https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# install yarn
RUN apt-get update -yq \
		&& apt-get remove cmdtest -yq \
		&& apt-get install gnupg -yq \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update -yq \
    && apt-get install yarn -yq

# ini settings for xdebug
RUN echo "xdebug.remote_enable = 1" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back = 1" \
        >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# install mhsendmail for sending mail commands to mailhog
RUN wget https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
    && chmod +x mhsendmail_linux_amd64 \
    && mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail

## PHPUnit installation
#RUN composer selfupdate \
#    && composer require "phpunit/phpunit" --prefer-source --no-interaction \
#    && ln -s /tmp/vendor/bin/phpunit /usr/local/bin/phpunit

WORKDIR /var/www/ca2