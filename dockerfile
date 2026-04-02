# Menggunakan base image PHP 8.2
FROM php:8.2-cli

# Install dependencies sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy Composer dari image resminya
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

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