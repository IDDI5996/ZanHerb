# Use PHP-FPM 8.3
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl nodejs npm \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev libxpm-dev libonig-dev libxml2-dev \
    sqlite3 \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure gd properly
RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/ \
    --with-webp=/usr/include/ \
    --with-xpm=/usr/include/

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

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
