FROM php:8.3.0-fpm

WORKDIR /backend

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get -y install \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    zlib1g-dev \
    npm \
    nodejs \
    vim
  
RUN docker-php-ext-install pdo pdo_mysql zip bcmath

ADD docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh
CMD ["/docker-entrypoint.sh"]
