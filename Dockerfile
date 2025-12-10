FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Enable Apache mod_rewrite (optional but recommended)
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install
