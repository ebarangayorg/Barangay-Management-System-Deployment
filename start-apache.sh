#!/bin/bash
# Set default port to 80 if $PORT is not defined
PORT=${PORT:-80}

# Update Apache ports.conf and default site config
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in the foreground
apache2-foreground
