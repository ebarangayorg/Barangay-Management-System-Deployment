FROM php:8.2-apache

RUN apt-get update && apt-get install -y libssl-dev unzip git curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Install dependencies first
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY . .

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy startup script
COPY start-apache.sh /start-apache.sh
RUN chmod +x /start-apache.sh

# Expose port (Railway will override)
EXPOSE 80

# Use startup script to start Apache
CMD ["/start-apache.sh"]
