FROM php:8.3-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends libzip-dev libpng-dev libjpeg-dev libfreetype6-dev unzip \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install mysqli pdo_mysql zip gd \
 && rm -rf /var/lib/apt/lists/*

COPY docker/php.ini /usr/local/etc/php/conf.d/hotel-erp.ini
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# coderatio/simple-backup only declares PHP 7 support; nothing in the app calls it.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader --ignore-platform-req=php

COPY . .
# Seed copy of the bundled images, restored into an empty uploads volume at startup.
RUN cp -a public/uploads /opt/uploads-seed && chown -R www-data:www-data public/uploads

COPY docker/entrypoint.sh /usr/local/bin/hotel-erp-entrypoint
RUN chmod +x /usr/local/bin/hotel-erp-entrypoint

ENTRYPOINT ["hotel-erp-entrypoint"]
CMD ["apache2-foreground"]
