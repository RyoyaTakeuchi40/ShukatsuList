FROM node:21.3.0-alpine

WORKDIR /var/www/nuxt

RUN apk update && \
    apk add git curl

ADD ./docker/front/front-entrypoint.sh /
RUN chmod +x /front-entrypoint.sh

ENTRYPOINT ["/front-entrypoint.sh"]