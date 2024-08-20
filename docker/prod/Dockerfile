FROM serversideup/php:8.3-fpm-nginx as base

# Install necessary PHP extensions
USER root
RUN install-php-extensions intl bcmath gd exif

FROM base as composer
WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-plugins --no-scripts --prefer-dist

FROM node:20 as static-assets
# Set environment variable for production
ENV NODE_ENV=production

WORKDIR /app
COPY package*.json ./
RUN npm install --production

COPY . .
COPY --from=composer --chown=www-data:www-data /var/www/html ./

# Build static assets
RUN npm run build

FROM base
WORKDIR /var/www/html

COPY --from=composer --chown=www-data:www-data /var/www/html ./
COPY --from=static-assets --chown=www-data:www-data /app/public/build ./public/build

# Set permissions
USER www-data

# Optimize Laravel application
RUN composer dump-autoload
RUN php artisan route:cache
RUN php artisan view:cache
