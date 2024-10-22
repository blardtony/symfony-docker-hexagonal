FROM dunglas/frankenphp:latest-php8.3 as build_php

COPY --from=composer/composer:2-bin /composer /usr/bin/composer

# ZIP
RUN apt-get update && apt-get install -y libzip-dev
RUN docker-php-ext-install zip

# PSQL
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# GD
RUN install-php-extensions gd

RUN install-php-extensions intl

# COMPOSER (for frontend)
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY symfony.lock symfony.lock
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-scripts

COPY public public

COPY bin bin
COPY config config
COPY src src
COPY migrations migrations

COPY .env .env

RUN php bin/console cache:clear

RUN chmod 755 -R .
RUN chmod 777 -R var/


FROM dunglas/frankenphp:latest-php8.3-alpine

RUN install-php-extensions \
    pdo \
    pdo_pgsql \
    pgsql \
    intl \
    gd

COPY --from=build_php /app /app
ENV FRANKENPHP_CONFIG="worker ./public/index.php"
ENV CADDY_GLOBAL_OPTIONS="auto_https off"
ENV SERVER_NAME=":80"
ENV APP_RUNTIME="Runtime\\FrankenPhpSymfony\\Runtime"
ENV APP_ENV="prod"