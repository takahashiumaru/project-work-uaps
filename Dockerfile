FROM php:8.2-fpm-alpine

# Install library runtime
RUN apk add --no-cache git curl bash libpng libxml2 icu-libs oniguruma unzip zip

# Ambil binary extension yang sudah jadi
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mbstring gd intl zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Otomatisasi: Clone -> Env -> Migrate -> Serve
CMD bash -c "if [ ! -f artisan ]; then git clone --depth 1 https://github.com/takahashiumaru/project-work-uaps.git .; fi && \
    composer install --no-interaction --prefer-dist --optimize-autoloader && \
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    sed -i 's/DB_HOST=.*/DB_HOST=db/' .env && \
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=aps/' .env && \
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=umarvps/' .env && \
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=umarvps/' .env && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    php artisan key:generate --force && \
    sleep 5 && php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80"