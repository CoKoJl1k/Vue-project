FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Копируем ВСЁ из папки backend (а не из корня)
COPY ./backend/ .

RUN composer install --no-interaction --optimize-autoloader

EXPOSE 8000

CMD ["sh", "-c", "php artisan schedule:work & php artisan serve --host=0.0.0.0 --port=8000"]
