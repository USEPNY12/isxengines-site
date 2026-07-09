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

# Fix authentication - switch root to mysql_native_password and create app user
mysql -u root --skip-password -e "ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING '';" 2>/dev/null || true
mysql -u root --skip-password -e "CREATE USER IF NOT EXISTS 'isxuser'@'localhost' IDENTIFIED BY 'ISXpass2026!';" 2>/dev/null || true
mysql -u root --skip-password -e "CREATE USER IF NOT EXISTS 'isxuser'@'127.0.0.1' IDENTIFIED BY 'ISXpass2026!';" 2>/dev/null || true
mysql -u root --skip-password -e "FLUSH PRIVILEGES;" 2>/dev/null || true

# Initialize database if needed
if ! mysql -u root --skip-password -e "USE isxengines_db" 2>/dev/null; then
    echo "Creating database..."
    mysql -u root --skip-password -e "CREATE DATABASE isxengines_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mysql -u root --skip-password -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxuser'@'localhost';"
    mysql -u root --skip-password -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxuser'@'127.0.0.1';"
    mysql -u root --skip-password -e "FLUSH PRIVILEGES;"
    mysql -u root --skip-password isxengines_db < /var/www/html/database/init.sql
    echo "Database initialized!"
else
    TABLE_COUNT=$(mysql -u root --skip-password -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='isxengines_db';" 2>/dev/null || echo "0")
    if [ "$TABLE_COUNT" -lt "5" ]; then
        echo "Re-initializing tables..."
        mysql -u root --skip-password -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxuser'@'localhost';" 2>/dev/null || true
        mysql -u root --skip-password -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxuser'@'127.0.0.1';" 2>/dev/null || true
        mysql -u root --skip-password -e "FLUSH PRIVILEGES;" 2>/dev/null || true
        mysql -u root --skip-password isxengines_db < /var/www/html/database/init.sql
        echo "Tables created!"
    fi
fi

echo "Starting Apache..."
exec apache2-foreground
