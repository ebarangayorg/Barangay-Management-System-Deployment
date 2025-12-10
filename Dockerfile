# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies and MongoDB extension
RUN apt-get update && apt-get install -y libssl-dev unzip git curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (for caching)
COPY composer.json composer.lock ./

# Install PHP dependencies inside container
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
COPY . .

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy startup script to handle dynamic Railway port
COPY start-apache.sh /start-apache.sh
RUN chmod +x /start-apache.sh

# Expose port (Railway will override with $PORT)
EXPOSE 80

# Start Apache via the startup script
CMD ["/start-apache.sh"]
