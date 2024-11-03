FROM php:8.3-fpm
LABEL author="jayme.anunciacao@gmail.com"

RUN apt update \
	&& apt install -y git libcurl4 libcurl4-openssl-dev libzip-dev unzip libsodium-dev libonig-dev libpq-dev libxml2-dev libxslt1-dev libpng-dev

RUN docker-php-ext-install zip mbstring pdo_pgsql pgsql sodium xml xsl curl ctype fileinfo gd

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" \
	&& php /tmp/composer-setup.php --install-dir=/usr/bin --filename=composer

WORKDIR /app

COPY ./php.conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

EXPOSE 8000
