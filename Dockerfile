FROM php:7.3.29-apache

RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y

# Install useful tools
RUN apt-get -y install apt-utils git nano wget dialog vim

# Install important libraries
RUN apt-get -y install --fix-missing apt-utils build-essential git curl libcurl3-dev zip libzip-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other PHP7 Extensions
RUN apt-get -y install libsqlite3-dev libsqlite3-0
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install mysqli

RUN apt-get -y install zlib1g-dev
RUN docker-php-ext-install zip

RUN apt-get -y install libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

RUN docker-php-ext-install mbstring

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ 
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install calendar
RUN docker-php-ext-install pcntl

RUN apt-get -y install libxml2-dev
RUN docker-php-ext-install soap

RUN docker-php-ext-install sockets
RUN docker-php-ext-install sysvmsg
RUN docker-php-ext-install sysvsem
RUN docker-php-ext-install sysvshm

RUN docker-php-ext-install gettext
RUN docker-php-ext-install wddx

RUN apt-get -y install libxslt1-dev python-dev
RUN docker-php-ext-install xsl

RUN docker-php-ext-install exif

RUN pecl install xdebug-2.9.0
RUN docker-php-ext-enable xdebug

RUN docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache

#add apache-dev
RUN apt-get -y install apache2-dev 