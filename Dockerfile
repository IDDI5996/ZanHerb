# ==============================
# 1. Base image with PHP + Apache
# ==============================
FROM php:8.3-apache

# Enable Apache modules
RUN a2enmod rewrite

# Step 1: Update and install basic dependencies
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        gnupg

# Step 2: Install the main packages
RUN apt-get update && \
    apt-get install -y \
        git \
        zip \
        unzip \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        sqlite3

# Step 3: Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring bcmath gd

# Step 4: Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# ==============================
# 2. Configure Apache
# ==============================
# Set Render dynamic port
ARG PORT
ENV PORT=${PORT}

# Update Apache to listen on Render’s PORT
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

# Setup Laravel public directory as Apache root
WORKDIR /var/www/html
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# ==============================
# 3. Install Composer & PHP deps
# ==============================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# ==============================
# 4. Install Node deps & build assets
# ==============================
RUN npm install && npm run build

# ==============================
# 5. Laravel optimize & permissions
# ==============================
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# ==============================
# 6. Entrypoint
# ==============================
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# ==============================
# 7. Expose port
# ==============================
EXPOSE ${PORT}
