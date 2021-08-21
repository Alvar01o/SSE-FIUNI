#!/bin/bash
cd /var/www/html/webserver/
composer install
chmod 777 -R storage
mv .env.example .env
php artisan key:generate
