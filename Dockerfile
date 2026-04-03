FROM php:8.2-fpm-alpine

# Install library runtime (tanpa kompilasi berat)
RUN apk add --no-cache git curl bash libpng libxml2 icu-libs oniguruma

# Ambil binary extension yang sudah jadi (Sangat Cepat & Hemat RAM)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mbstring gd intl zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Otomatisasi: Clone -> Env -> Migrate -> Serve
CMD bash -c "if [ ! -f artisan ]; then git clone https://github.com/takahashiumaru/project-work-uaps.git .; fi && \
    composer install --no-interaction --prefer-dist && \
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' .env && \
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=aps/' .env && \
    sed -i 's/DB_USERNAME=root/DB_USERNAME=umarvps/' .env && \
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=umarvps/' .env && \
    php artisan key:generate --force && \
    sleep 10 && php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80"