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

# Copy composer files first (for caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
COPY . .

# Ensure uploads folders exist and are writable
RUN mkdir -p /var/www/html/uploads/announcements \
    && mkdir -p /var/www/html/uploads/residents \
    && mkdir -p /var/www/html/uploads/officials \
    && chmod -R 777 /var/www/html/uploads

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy startup script
COPY start-apache.sh /start-apache.sh
RUN chmod +x /start-apache.sh

# Expose port (Railway overrides with $PORT)
EXPOSE 80

# Start Apache
CMD ["/start-apache.sh"]
