FROM php:8.2-fpm-alpine

RUN apk add --no-cache git curl bash libpng-dev libxml2-dev icu-dev oniguruma-dev zlib-dev libzip-dev
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mbstring gd intl zip bcmath
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Script Cleanup & Setup: Pastikan link storage bersih dan permission tepat
CMD bash -c "if [ ! -f artisan ]; then git clone https://github.com/takahashiumaru/project-work-uaps.git .; fi && \
    composer install --no-interaction --prefer-dist && \
    [ ! -f .env ] && cp .env.example .env && \
    php artisan key:generate --force && \
    sed -i 's|APP_URL=.*|APP_URL=http://\${MY_VPS_IP}|' .env && \
    chown -R www-data:www-data storage bootstrap/cache public && \
    chmod -R 775 storage bootstrap/cache public && \
    rm -rf public/storage && \
    php artisan storage:link && \
    echo 'Menunggu MySQL...' && sleep 5 && \
    php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan serve --host=0.0.0.0 --port=80"
