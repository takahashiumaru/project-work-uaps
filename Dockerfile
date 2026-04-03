# Menggunakan image yang sudah lengkap ekstensinya (Sangat Ringan & Cepat)
FROM serversideup/php:8.2-fpm-apache-alpine

USER root

# Install git untuk cloning
RUN apk add --no-cache git

WORKDIR /var/www/html

# Script otomatis: Clone -> Config -> Migrate -> Run
# Port default image ini adalah 8080, kita sesuaikan nanti di docker run
CMD sh -c "if [ ! -f artisan ]; then git clone https://github.com/takahashiumaru/project-work-uaps.git .; fi && \
    composer install --no-interaction --prefer-dist && \
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' .env && \
    sed -i 's/DB_DATABASE=laravel/DB_DATABASE=aps/' .env && \
    sed -i 's/DB_USERNAME=root/DB_USERNAME=umarvps/' .env && \
    sed -i 's/DB_PASSWORD=/DB_PASSWORD=umarvps/' .env && \
    php artisan key:generate --force && \
    sleep 10 && php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=80"