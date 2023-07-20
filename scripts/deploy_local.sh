#!/bin/bash
set -e

echo "Local deployment started ..."

# creating .env
cp .env.example .env

composer install
composer dump-autoload

php artisan migrate:fresh --seed

# Clear and cache config
php artisan config:clear
php artisan cache:clear

echo "Deployment finished!"