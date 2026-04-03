FROM php:8.2-fpm-alpine

# Install tools dasar
RUN apk add --no-cache curl bash libpng-dev libxml2-dev icu-dev oniguruma-dev zlib-dev libzip-dev shadow

# Install PHP extensions sakti
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mbstring gd intl zip bcmath exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy semua file (termasuk vendor kalau lu build lokal, tapi biasanya diignore)
COPY . .

# Optimasi Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Atur Permission biar nggak error 500
RUN chown -R www-data:www-data storage bootstrap/cache public && \
    chmod -R 775 storage bootstrap/cache public

# Jalankan Laravel
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000