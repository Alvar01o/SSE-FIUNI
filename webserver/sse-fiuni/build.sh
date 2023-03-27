#!/bin/bash
cd /var/www/html/webserver
# Crear un usuario nuevo
useradd -m -s /bin/bash sse
# Establecer una contraseña para el usuario
passwd sse
# Iniciar sesión como el nuevo usuario
su - sse
composer install
chmod 777 -R storage
cp .env.example .env
php artisan key:generate
chmod 777 -R storage/
php artisan storage:link
php artisan config:clear
