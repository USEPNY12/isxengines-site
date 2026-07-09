FROM php:8.1-apache

# Install PHP extensions and MariaDB
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    mariadb-server mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Configure Apache to allow .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/assets/uploads \
    && chmod -R 777 /var/www/html/assets/uploads \
    && chmod +x /var/www/html/docker-entrypoint.sh

# Initialize MySQL data directory at build time (fresh)
RUN rm -rf /var/lib/mysql/* && \
    mkdir -p /var/lib/mysql /run/mysqld && \
    chown -R mysql:mysql /var/lib/mysql /run/mysqld && \
    chmod 755 /var/lib/mysql /run/mysqld && \
    mysql_install_db --user=mysql --datadir=/var/lib/mysql 2>/dev/null || \
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql

EXPOSE 80

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
