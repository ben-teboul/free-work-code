FROM php:8.1-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y git unzip zip

WORKDIR /var/www/html

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql bcmath zip intl opcache

COPY --from=composer:2.4.4 /usr/bin/composer /usr/local/bin/composer

RUN apt-get dist-upgrade && apt-get update

RUN #apt-get install -y python3.10 python3-pip

RUN curl -sS https://get.symfony.com/cli/installer | bash

RUN  mv /root/.symfony5/bin/symfony /usr/local/bin/symfony


RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs poppler-utils
RUN npm install
RUN npm install --global yarn

RUN apt-get install -y wkhtmltopdf
#RUN apt-get install -y wkhtmltoimage