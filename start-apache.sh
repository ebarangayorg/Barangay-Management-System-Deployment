#!/bin/bash
# Use PORT env var (Railway) or default 80
PORT=${PORT:-80}

# Update Apache configs
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in foreground
apache2-foreground
