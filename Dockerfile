FROM php:8.4-fpm-alpine

RUN apk update \
   && apk add libpq-dev curl php-curl

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql  \
    && docker-php-ext-install pgsql pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer



