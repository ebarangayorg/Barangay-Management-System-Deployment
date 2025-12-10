#!/bin/bash
PORT=${PORT:-80}

# Update Apache ports
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Pass Railway env vars to PHP
echo "SetEnv MONGO_URI $MONGO_URI" >> /etc/apache2/apache2.conf
echo "SetEnv DB_NAME $DB_NAME" >> /etc/apache2/apache2.conf

# Start Apache in the foreground
apache2-foreground
