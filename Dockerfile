# Base image: PHP 8.2 with Apache
FROM php:8.2-apache

# Install dependencies, MongoDB extension, and enable Apache mod_rewrite
RUN apt-get update && apt-get install -y libssl-dev unzip git curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
COPY . .

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
