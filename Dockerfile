FROM php:8.2-apache

# Install required system packages, MariaDB server, and PHP extension build dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    mariadb-server \
    mariadb-client \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    ca-certificates \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl mysqli pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Optimize MariaDB memory footprint for Render Free Tier (512MB RAM total)
RUN mkdir -p /etc/mysql/mariadb.conf.d \
    && echo "[mysqld]\n\
skip-innodb-doublewrite\n\
innodb_buffer_pool_size=32M\n\
innodb_log_buffer_size=8M\n\
key_buffer_size=16M\n\
max_connections=30\n\
query_cache_size=0\n\
query_cache_type=0" > /etc/mysql/mariadb.conf.d/99-render.cnf

# Enable Apache mod_rewrite & headers
RUN a2enmod rewrite headers

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Copy custom Apache virtual host configuration
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Install composer production dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configure script permissions and ownership
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/writable \
    && sed -i 's/\r$//' /var/www/html/docker/entrypoint.sh \
    && chmod +x /var/www/html/docker/entrypoint.sh

# Expose HTTP port
EXPOSE 80 10000

# Set entrypoint
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
