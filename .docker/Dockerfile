FROM php:8.3-apache

COPY --from=composer/composer:2-bin /composer /usr/bin/composer

# ZIP
RUN apt-get update && apt-get install -y libzip-dev
RUN docker-php-ext-install zip

# PSQL
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# GD
RUN #install-php-extensions gd

# Apache
RUN a2enmod rewrite

COPY bin bin
COPY config config
COPY src src
COPY migrations migrations

# Composer
COPY composer.json .
COPY composer.lock .
COPY symfony.lock .
ENV COMPOSER_ALLOW_SUPERUSER=1


COPY public public
COPY .env .env

RUN composer install --optimize-autoloader --no-scripts
RUN php bin/console cache:clear

RUN chmod 755 -R .
RUN chmod 777 -R var/

COPY .docker/.apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

EXPOSE 80

# Healthcheck
HEALTHCHECK --interval=10s --timeout=3s --start-period=30s \
    CMD php bin/console doctrine:query:sql "SELECT 1" || exit 1

CMD ["apache2-foreground"]
