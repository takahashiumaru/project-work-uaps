FROM php:8.2-fpm-alpine

# Build argument for cache busting
ARG CACHEBUST=1

# Install library runtime
RUN apk add --no-cache git curl bash libpng libxml2 icu-libs oniguruma unzip zip mysql-client

# Ambil binary extension yang sudah jadi
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql mbstring gd intl zip bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# BUILD PHASE: Clone & Install (Optimized for VPS cache)
RUN git clone --depth 1 https://github.com/takahashiumaru/project-work-uaps.git . && \
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Fix permissions at build time
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# RUNTIME PHASE: Setup Env -> Wait DB -> Migrate -> Serve
CMD bash -c "if [ ! -f .env ]; then cp .env.example .env; fi && \
    sed -i 's/DB_HOST=.*/DB_HOST=db/' .env && \
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=aps/' .env && \
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=umarvps/' .env && \
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=umarvps/' .env && \
    php artisan key:generate --force && \
    echo 'Waiting for MySQL (db:3306)...' && \
    until mysqladmin ping -h db --silent; do sleep 3; done && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80"