FROM php:8.3.0-fpm-alpine

WORKDIR /backend

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

ADD docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh
CMD ["/docker-entrypoint.sh"]
