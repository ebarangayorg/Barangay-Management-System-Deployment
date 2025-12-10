FROM php:8.2-apache

# Install dependencies and MongoDB extension
RUN apt-get update && apt-get install -y libssl-dev unzip git curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy composer files first and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
COPY . .

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy and enable startup script
COPY start-apache.sh /start-apache.sh
RUN chmod +x /start-apache.sh

# Expose port (Railway overrides $PORT)
EXPOSE 80

# Start Apache via startup script
CMD ["/start-apache.sh"]
