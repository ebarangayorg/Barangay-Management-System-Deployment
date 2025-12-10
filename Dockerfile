# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies, MongoDB extension, and unzip (for composer)
RUN apt-get update && apt-get install -y libssl-dev unzip git curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (caching benefit)
COPY composer.json composer.lock ./

# Install PHP dependencies inside container
RUN composer install --no-dev --optimize-autoloader

# Copy rest of the project (excluding local vendor/)
COPY . .

# Ensure uploads folders exist and are writable
RUN mkdir -p uploads/announcements \
    && mkdir -p uploads/residents \
    && mkdir -p uploads/officials \
    && chmod -R 777 uploads

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy startup script
COPY start-apache.sh /start-apache.sh
RUN chmod +x /start-apache.sh

# Expose default port (Railway overrides $PORT automatically)
EXPOSE 80

# Start Apache
CMD ["/start-apache.sh"]
