#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

php artisan key:generate
php artisan migrate
#php artisan optimize clear
php artisan view:clear
php artisan route:clear

# Scheduler
while true; do
    php artisan app:fetch-news
    sleep 3600
done &

php-fpm -D
nginx -g "daemon off;"
