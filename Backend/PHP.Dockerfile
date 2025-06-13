FROM php:8.2-fpm

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libssl-dev \
    libonig-dev \
    libargon2-1 \
    libsodium-dev \
    libmcrypt-dev \
    libcurl4-openssl-dev

RUN docker-php-ext-install pdo pdo_mysql zip

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
