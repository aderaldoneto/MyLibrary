FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    libicu-dev \
    libpq-dev \
    unzip \
    && docker-php-ext-install intl pdo_pgsql opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf