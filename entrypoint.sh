#!/bin/sh
# Database migrate karein
php artisan migrate --force

# Application start karein
exec php-fpm