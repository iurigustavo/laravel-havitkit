FROM serversideup/php:8.3-fpm-nginx as base

# Install necessary PHP extensions
USER root
RUN install-php-extensions intl bcmath gd exif

FROM base as composer
WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist


FROM node:20 as static-assets
WORKDIR /app
COPY . .
COPY --from=composer --chown=www-data:www-data /var/www/html .
RUN npm install
RUN npm run build

FROM base
WORKDIR /var/www/html

COPY --from=composer --chown=www-data:www-data /var/www/html .
COPY --chown=www-data:www-data . .

USER www-data

RUN composer dump-autoload

COPY --from=static-assets --chown=www-data:www-data /app/public/build ./public/build

RUN php artisan route:cache
RUN php artisan view:cache
