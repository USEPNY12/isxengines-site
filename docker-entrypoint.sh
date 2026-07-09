#!/bin/bash
set -e

echo "Starting ISX Engines..."

# Initialize MySQL data directory if empty
if [ ! -d "/var/lib/mysql/mysql" ]; then
    echo "Initializing MariaDB data directory..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql 2>/dev/null || mariadb-install-db --user=mysql --datadir=/var/lib/mysql 2>/dev/null || true
fi

# Ensure proper permissions
chown -R mysql:mysql /var/lib/mysql /run/mysqld 2>/dev/null || true

# Start MariaDB in background
echo "Starting MariaDB..."
mysqld_safe --skip-grant-tables &

# Wait for MySQL to be ready
echo "Waiting for MariaDB to be ready..."
for i in {1..60}; do
    if mysqladmin ping --silent 2>/dev/null; then
        echo "MariaDB is ready!"
        break
    fi
    sleep 1
done

# Set up grants (since we started with skip-grant-tables)
mysql -e "FLUSH PRIVILEGES;" 2>/dev/null || true
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '';" 2>/dev/null || true
mysql -e "CREATE USER IF NOT EXISTS 'isxengines_user'@'localhost' IDENTIFIED BY 'ISXEngines2026!';" 2>/dev/null || true

# Check if database exists, if not create it
if ! mysql -e "USE isxengines_db" 2>/dev/null; then
    echo "Initializing database..."
    mysql -e "CREATE DATABASE isxengines_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mysql -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxengines_user'@'localhost';"
    mysql -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'root'@'localhost';"
    mysql -e "FLUSH PRIVILEGES;"
    mysql isxengines_db < /var/www/html/database/init.sql
    echo "Database initialized successfully!"
else
    # Check if tables exist
    TABLE_COUNT=$(mysql -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='isxengines_db';" 2>/dev/null || echo "0")
    if [ "$TABLE_COUNT" -lt "5" ]; then
        echo "Database exists but tables missing. Re-initializing..."
        mysql -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxengines_user'@'localhost';" 2>/dev/null || true
        mysql -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'root'@'localhost';" 2>/dev/null || true
        mysql -e "FLUSH PRIVILEGES;" 2>/dev/null || true
        mysql isxengines_db < /var/www/html/database/init.sql
        echo "Tables created successfully!"
    fi
fi

echo "Starting Apache..."
# Start Apache in foreground
exec apache2-foreground
