FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Permisos correctos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Puerto de Laravel
EXPOSE 8000

# Ejecutar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
