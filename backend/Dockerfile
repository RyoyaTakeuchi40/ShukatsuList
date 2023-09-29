FROM php:8.2.8-apache

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
COPY ./backend/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update \
    && apt-get install -y wget git unzip libpq-dev \
    && docker-php-ext-install pdo_mysql\
    && : 'Install Node.js' \
    &&  curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && : 'Install PHP Extensions' \
    && docker-php-ext-install -j$(nproc) pdo_pgsql 

WORKDIR /var/www

RUN echo "Listen 8080" >> /etc/apache2/ports.conf && \
    a2enmod rewrite
    