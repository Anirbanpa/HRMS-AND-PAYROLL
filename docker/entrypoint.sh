#!/bin/bash
set -e

# Render dynamic port assignment (defaults to 10000 on Render, 80 locally)
APP_PORT="${PORT:-80}"

# Configure Apache listening port
sed -i "s/Listen 80/Listen ${APP_PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:*>/<VirtualHost \*:${APP_PORT}>/" /etc/apache2/sites-available/*.conf

# Detect base URL
if [ -n "$RENDER_EXTERNAL_URL" ]; then
    BASE_URL="${RENDER_EXTERNAL_URL}/"
else
    BASE_URL="http://localhost:${APP_PORT}/"
fi

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

    # Create user and enterprise_hrms database
    mysql -u root -e "CREATE DATABASE IF NOT EXISTS enterprise_hrms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || true
    mysql -u root -e "CREATE USER IF NOT EXISTS 'hrms_user'@'%' IDENTIFIED BY 'hrms_pass';" 2>/dev/null || true
    mysql -u root -e "CREATE USER IF NOT EXISTS 'hrms_user'@'localhost' IDENTIFIED BY 'hrms_pass';" 2>/dev/null || true
    mysql -u root -e "GRANT ALL PRIVILEGES ON enterprise_hrms.* TO 'hrms_user'@'%'; GRANT ALL PRIVILEGES ON enterprise_hrms.* TO 'hrms_user'@'localhost'; FLUSH PRIVILEGES;" 2>/dev/null || true

    # Check if tables exist, if not import snapshot
    TABLE_COUNT=$(mysql -u root -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='enterprise_hrms';" 2>/dev/null || echo 0)
    if [ "$TABLE_COUNT" -eq 0 ] && [ -f "/var/www/html/database/enterprise_hrms_full.sql" ]; then
        echo "==> Initializing enterprise_hrms database from snapshot..."
        mysql -u root enterprise_hrms < /var/www/html/database/enterprise_hrms_full.sql 2>/dev/null || true
        echo "==> Database snapshot loaded successfully!"
    fi

    DB_HOST="127.0.0.1"
    DB_USER="hrms_user"
    DB_PASS="hrms_pass"
    DB_NAME="enterprise_hrms"
else
    echo "==> External database configuration detected. Skipping embedded MariaDB."
    DB_HOST="${DATABASE_DEFAULT_HOSTNAME:-${database_default_hostname:-$DB_HOST}}"
    DB_USER="${DATABASE_DEFAULT_USERNAME:-${database_default_username:-$DB_USER}}"
    DB_PASS="${DATABASE_DEFAULT_PASSWORD:-${database_default_password:-$DB_PASSWORD}}"
    DB_NAME="${DATABASE_DEFAULT_DATABASE:-${database_default_database:-${DB_NAME:-enterprise_hrms}}}"
fi

# Generate production .env for CodeIgniter 4
cat <<EOF > /var/www/html/.env
CI_ENVIRONMENT = production
app.baseURL = '${BASE_URL}'
app.forceGlobalSecureRequests = false
app.CSPEnabled = false

database.default.hostname = ${DB_HOST}
database.default.database = ${DB_NAME}
database.default.username = ${DB_USER}
database.default.password = ${DB_PASS}
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
database.default.charset = utf8mb4
database.default.DBCollat = utf8mb4_unicode_ci

security.csrfProtection = 'cookie'
security.tokenRandomize = true
security.tokenName = 'csrf_test_name'
security.headerName = 'X-CSRF-TOKEN'
security.cookieName = 'csrf_cookie_name'
security.expires = 7200
security.regenerate = false
security.redirect = false
security.samesite = 'Lax'
EOF

# Set permissions for writable directory (logs, cache, sessions, uploads)
mkdir -p /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session /var/www/html/writable/uploads /var/www/html/writable/debugbar
chown -R www-data:www-data /var/www/html/writable /var/www/html/.env
chmod -R 775 /var/www/html/writable

echo "==> Starting Apache on port ${APP_PORT}..."
exec apache2-foreground
