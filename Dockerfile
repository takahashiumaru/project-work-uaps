FROM php:8.2-fpm-alpine

# Install tools dasar
RUN apk add --no-cache git curl bash

# Install PHP Extensions dengan cara yang jauh lebih stabil (mencegah error kompilasi mbstring)
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring gd intl zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Script otomatis: Clone -> Install -> Config -> Migrate -> Run
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