#!/bin/bash
set -e

echo "=== Starting ISX Engines ==="

# Ensure MySQL directories have correct permissions
chown -R mysql:mysql /var/lib/mysql /run/mysqld 2>/dev/null || true
chmod 755 /run/mysqld 2>/dev/null || true

# Start MariaDB
echo "Starting MariaDB..."
mysqld_safe &

# Wait for MySQL to be ready
echo "Waiting for MariaDB..."
for i in $(seq 1 60); do
    if mysqladmin ping --silent 2>/dev/null; then
        echo "MariaDB is ready!"
        break
    fi
    if [ "$i" -eq 60 ]; then
        echo "ERROR: MariaDB failed to start!"
        exit 1
    fi
    sleep 1
done

# Initialize database if needed
if ! mysql -e "USE isxengines_db" 2>/dev/null; then
    echo "Creating database..."
    mysql -e "CREATE DATABASE isxengines_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mysql -e "CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED BY '';"
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;"
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;"
    mysql -e "FLUSH PRIVILEGES;"
    mysql isxengines_db < /var/www/html/database/init.sql
    echo "Database initialized!"
else
    TABLE_COUNT=$(mysql -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='isxengines_db';" 2>/dev/null || echo "0")
    if [ "$TABLE_COUNT" -lt "5" ]; then
        echo "Re-initializing tables..."
        mysql isxengines_db < /var/www/html/database/init.sql
        echo "Tables created!"
    fi
fi

echo "Starting Apache..."
exec apache2-foreground
