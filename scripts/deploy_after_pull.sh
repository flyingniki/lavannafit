#!/bin/sh
set -eu

# Run production-safe updates after git pull on the server.
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
