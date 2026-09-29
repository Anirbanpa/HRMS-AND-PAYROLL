#!/bin/bash
set -e

# Render dynamic port assignment (defaults to 10000 on Render, 80 locally)
APP_PORT="${PORT:-80}"

# Configure Apache listening port
sed -i "s/Listen 80/Listen ${APP_PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:*>/<VirtualHost \*:${APP_PORT}>/" /etc/apache2/sites-available/*.conf

# Set permissions for writable directory (logs, cache, sessions, uploads)
mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session /var/www/html/writable/uploads /var/www/html/writable/debugbar
chown -R www-data:www-data /var/www/html/writable
chmod -R 775 /var/www/html/writable

# Start Apache in foreground
exec apache2-foreground
