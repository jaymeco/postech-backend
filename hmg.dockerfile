FROM php:8.3-apache
LABEL author="jayme.anunciacao@gmail.com"

RUN a2dissite 000-default.conf
RUN a2enmod rewrite

RUN apt update \
	&& apt install -y git libcurl4 libcurl4-openssl-dev libzip-dev unzip libsodium-dev libonig-dev libpq-dev libxml2-dev libxslt1-dev libpng-dev

RUN docker-php-ext-install zip mbstring pdo_pgsql pgsql pdo_mysql mysqli sodium xml xsl curl ctype fileinfo gd

RUN docker-php-ext-enable pdo_mysql mysqli

RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" \
	&& php /tmp/composer-setup.php --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html/

COPY ./ /var/www/html/

RUN composer install
RUN chmod 777 -R bootstrap storage public vendor

# Configuração apache
COPY ./php.conf/apache.conf /etc/apache2/sites-available
RUN a2ensite apache.conf

EXPOSE 80
