#!/bin/sh

php artisan migrate
php artisan migrate:fresh --seed

if [ -f /var/www/html/database.sqlite ]; then
    echo "Setting permissions for database.sqlite"
    chown www-data:www-data /var/www/html/database.sqlite
    chmod 664 /var/www/html/database.sqlite
fi

php artisan cache:clear
#php artisan queue:work --daemon &

exec "$@"
