# Menggunakan base image PHP 8.2 with Apache
FROM php:8.2-apache

# 1. Ambil script installer PHP extensions dari image mlocati
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# 2. Install ekstensi PHP yang dibutuhkan Laravel dan Composer
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring exif pcntl bcmath gd @composer zip

# 3. Install git dan unzip (wajib untuk Composer saat fetching packages)
RUN apt-get update && apt-get install -y git unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Konfigurasi Apache: Ubah DocumentRoot ke /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Aktifkan mod_rewrite Apache (PENTING untuk routing Laravel)
RUN a2enmod rewrite

# Set direktori kerja di dalam container
WORKDIR /var/www/html

# Copy seluruh file project ke dalam container
COPY . /var/www/html

# 6. Install dependency Laravel menggunakan Composer
# Kita menggunakan --no-dev untuk produksi agar image tetap ramping
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 7. Berikan hak akses untuk folder storage dan cache agar Laravel bisa menulis log/session
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Buka port 80 (standard Apache)
EXPOSE 80

# Apache akan otomatis dijalankan oleh base image (CMD ["apache2-foreground"])