FROM php:8.2-fpm-alpine

# Install library OS (Sangat Ringan)
RUN apk add --no-cache git curl bash libpng-dev libxml2-dev icu-dev oniguruma-dev zlib-dev libzip-dev

# Ambil installer ekstensi PHP instan (Anti-Error Kompilasi)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mbstring gd intl zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Otomatisasi: Clone -> Env -> Permission -> Migrate -> Serve
CMD bash -c "if [ ! -f artisan ]; then git clone https://github.com/takahashiumaru/project-work-uaps.git .; fi && \
    composer install --no-interaction --prefer-dist && \
    [ ! -f .env ] && cp .env.example .env && \
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' .env && \
    sed -i 's/DB_PORT=3306/DB_PORT=3306/' .env && \
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=aps/' .env && \
    sed -i 's/DB_USERNAME=root/DB_USERNAME=umarvps/' .env && \
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=umarvps/' .env && \
    php artisan key:generate --force && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    echo 'Menunggu MySQL stabil...' && sleep 10 && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan serve --host=0.0.0.0 --port=80"