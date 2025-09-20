FROM php:8.3-fpm

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer Composer
COPY --from=composer:2.8.11 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier uniquement composer.* pour tirer parti du cache
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-interaction --prefer-dist --optimize-autoloader

# Copier tout le code
COPY . .

# Droits
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
