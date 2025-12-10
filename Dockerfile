FROM php:8.2-apache

# Install system dependencies and MongoDB PHP extension
RUN apt-get update && apt-get install -y libssl-dev unzip git \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy rest of project files
COPY . .

# Optional: expose port 80
EXPOSE 80
