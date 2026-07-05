FROM php:8.4-cli

# Устанавливаем зависимости, включая libzip-dev
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql zip

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Копируем код
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install --no-interaction --optimize-autoloader

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
