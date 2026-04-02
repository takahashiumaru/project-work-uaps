# Menggunakan base image PHP 8.2
FROM php:8.2-cli

# 1. Ambil script installer dari image resminya
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# 2. Install ekstensi PHP dan Composer
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd @composer zip

# 3. Install git dan unzip (wajib untuk Composer)
RUN apt-get update && apt-get install -y git unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set direktori kerja di dalam container
WORKDIR /app

# Copy seluruh file project ke dalam container
COPY . /app

# Install package Laravel via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Berikan hak akses untuk folder storage dan cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Buka port 8000
EXPOSE 8000

# Perintah yang dijalankan saat container hidup
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]