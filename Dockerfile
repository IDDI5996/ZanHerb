# ===============================
# ZanHerb Laravel + Tailwind + Vite Dockerfile (with build inside)
# ===============================

# -------------------------------
# 1) Build frontend assets
# -------------------------------
FROM node:20 AS frontend

WORKDIR /app
COPY package*.json vite.config.* postcss.config.* tailwind.config.* ./
RUN npm install
COPY resources ./resources
COPY public ./public
RUN npm run build

# -------------------------------
# 2) PHP + Apache for Laravel
# -------------------------------
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev \
    libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Copy built frontend assets from node build
COPY --from=frontend /app/public/build ./public/build

# Configure Apache to serve Laravel public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

# Create SQLite database file if missing
RUN mkdir -p database \
    && touch database/database.sqlite

# Install Composer and Laravel dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Set permissions (for SQLite + cache)
RUN chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Run Laravel migrations on container start
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

# Start Apache
CMD ["apache2-foreground"]

# Expose port 80
EXPOSE 80
