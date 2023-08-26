FROM php:8.0-apache

RUN apt update \
        && apt install -y \
            g++ \
		openssl\
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
        && docker-php-ext-install \
            intl \
            opcache \
            pdo \
		pdo_mysql \
            pdo_pgsql \
            pgsql 
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
RUN pecl install mongodb \
&& echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/ext-mongodb.ini
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN curl -sL https://deb.nodesource.com/setup_18.x   | bash -
RUN apt-get -y install nodejs

WORKDIR /var/www/apps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
