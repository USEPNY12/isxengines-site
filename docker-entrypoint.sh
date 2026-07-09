#!/bin/bash
set -e

# Start MySQL
service mariadb start || {
    # First time - install MariaDB
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql
    service mariadb start
}

# Wait for MySQL to be ready
for i in {1..30}; do
    if mariadb -e "SELECT 1" &>/dev/null; then
        break
    fi
    sleep 1
done

# Check if database exists, if not create it
if ! mariadb -e "USE isxengines_db" 2>/dev/null; then
    echo "Initializing database..."
    mariadb -e "CREATE DATABASE isxengines_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mariadb -e "CREATE USER IF NOT EXISTS 'isxengines_user'@'localhost' IDENTIFIED BY 'ISXEngines2026!';"
    mariadb -e "GRANT ALL PRIVILEGES ON isxengines_db.* TO 'isxengines_user'@'localhost';"
    mariadb -e "FLUSH PRIVILEGES;"
    mariadb isxengines_db < /var/www/html/database/init.sql
    echo "Database initialized successfully!"
else
    # Check if tables exist (in case DB was created but not populated)
    TABLE_COUNT=$(mariadb -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='isxengines_db';")
    if [ "$TABLE_COUNT" -lt "5" ]; then
        echo "Database exists but tables missing. Re-initializing..."
        mariadb isxengines_db < /var/www/html/database/init.sql
        echo "Tables created successfully!"
    fi
fi

# Start Apache in foreground
apache2-foreground
