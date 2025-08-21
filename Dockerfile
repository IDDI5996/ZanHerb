# Use PHP-FPM 8.3
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev curl \
    nodejs npm \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory to project root
WORKDIR /var/www

# Copy project files (including /public/build)
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimizations
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Expose Render port
EXPOSE 10000

# Start Laravel built-in server (serves /public automatically)
CMD php artisan serve --host=0.0.0.0 --port=10000
