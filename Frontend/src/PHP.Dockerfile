# Use an official PHP image with extensions needed for most web apps
FROM php:8.2-fpm

# Install common PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /app

# Copy project files (if needed, but your volumes already handle this in docker-compose)
# COPY . /app

# Expose port (optional, since Nginx handles this)
EXPOSE 9000
