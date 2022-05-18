#!/bin/bash
composer install
chmod 777 -R storage
cp .env.example .env
php artisan key:generate
chmod 777 -R storage/
php artisan storage:link
