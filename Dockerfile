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

# Set default port to 80 if $PORT is not defined (for local testing)
ARG RAILWAY_PORT=80
ENV APACHE_LISTEN_PORT=${PORT:-$RAILWAY_PORT}

# Suppress Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Update Apache to listen on the correct port
RUN sed -i "s/80/${APACHE_LISTEN_PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Expose the port
EXPOSE ${APACHE_LISTEN_PORT}

# Start Apache in the foreground
CMD ["apache2-foreground"]
