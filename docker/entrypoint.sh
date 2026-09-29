#!/bin/bash
set -e

# Render dynamic port assignment (defaults to 10000 on Render, 80 locally)
APP_PORT="${PORT:-80}"

# Configure Apache listening port
sed -i "s/Listen 80/Listen ${APP_PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:*>/<VirtualHost \*:${APP_PORT}>/" /etc/apache2/sites-available/*.conf

# Check if external MySQL host is provided in environment; if not, use embedded MariaDB
if [ -z "$DATABASE_DEFAULT_HOSTNAME" ] && [ -z "$database_default_hostname" ] && [ -z "$DB_HOST" ]; then
    echo "==> Starting embedded MariaDB database service..."
    service mariadb start

    # Wait for MariaDB to become ready
    for i in {1..30}; do
        if mysqladmin ping --silent 2>/dev/null; then
            break
        fi
        sleep 1
    done

    # Check if enterprise_hrms database exists, if not, create and import snapshot
    DB_EXISTS=$(mysql -u root -e "SHOW DATABASES LIKE 'enterprise_hrms';" 2>/dev/null | grep enterprise_hrms || true)
    if [ -z "$DB_EXISTS" ]; then
        echo "==> Initializing enterprise_hrms database from snapshot..."
        mysql -u root -e "CREATE DATABASE IF NOT EXISTS enterprise_hrms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
        if [ -f "/var/www/html/database/enterprise_hrms_full.sql" ]; then
            mysql -u root enterprise_hrms < /var/www/html/database/enterprise_hrms_full.sql 2>/dev/null
            echo "==> Database snapshot loaded successfully!"
        fi
    fi
else
    echo "==> External database configuration detected. Skipping embedded MariaDB."
fi

# Set permissions for writable directory (logs, cache, sessions, uploads)
mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session /var/www/html/writable/uploads /var/www/html/writable/debugbar
chown -R www-data:www-data /var/www/html/writable
chmod -R 775 /var/www/html/writable

echo "==> Starting Apache on port ${APP_PORT}..."
exec apache2-foreground
