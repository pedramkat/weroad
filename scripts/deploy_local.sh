#!/bin/bash
set -e

echo "Local deployment started ..."

composer install
composer dump-autoload

php artisan migrate:fresh --seed

# Clear and cache config
php artisan config:clear
php artisan cache:clear

php artisan serve

echo "Deployment finished!"