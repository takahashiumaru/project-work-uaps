FROM php:8.2-fpm-alpine

# Install tools dasar & ekstensi PHP untuk MySQL
RUN apk add --no-cache git curl libpng-dev oniguruma-dev libxml2-dev icu-dev \
    && docker-php-ext-install pdo_mysql mbstring gd intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Logic: Clone -> Install -> Config .env -> Migrate -> Serve
CMD sh -c "if [ ! -f artisan ]; then git clone https://github.com/takahashiumaru/project-work-uaps.git .; fi && \
    composer install --no-interaction && \
    cp .env.example .env && \
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' .env && \
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=aps/' .env && \
    sed -i 's/DB_USERNAME=root/DB_USERNAME=umarvps/' .env && \
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=umarvps/' .env && \
    php artisan key:generate && \
    sleep 10 && php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80"