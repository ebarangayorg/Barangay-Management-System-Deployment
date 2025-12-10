FROM php:8.2-apache

RUN apt-get update && apt-get install -y libssl-dev unzip git curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the project
COPY . .

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Startup script
COPY start-apache.sh /start-apache.sh
RUN chmod +x /start-apache.sh

EXPOSE 80
CMD ["/start-apache.sh"]
