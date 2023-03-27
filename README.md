# SSE-FIUNI

Sistema de seguimiento de egresados FIUNI

## Instrucciones

```sh
git clone https://github.com/Alvar01o/SSE-FIUNI.git
cd SSE-FIUNI
docker-compose build
docker-compose up
```

Entrar en el contenedor usando

```
docker ps
```

>> CONTAINER ID   IMAGE                COMMAND                  CREATED         STATUS         PORTS                    NAMES
>> a1ab67e67d7e   sse-fiuni_sse-web    "docker-php-entrypoi…"   8 minutes ago   Up 8 minutes   0.0.0.0:80->80/tcp       sse-fiuni_sse-web_1
>> 3b829aec195a   sse-fiuni_sse-jobs   "docker-php-entrypoi…"   8 minutes ago   Up 8 minutes   0.0.0.0:8081->80/tcp     sse-fiuni_sse-jobs_1
>> 22e96744bfe0   adminer              "entrypoint.sh docke…"   8 minutes ago   Up 8 minutes   0.0.0.0:8080->8080/tcp   sse-fiuni_adminer_1
>> 2803f95b2b15   mariadb              "docker-entrypoint.s…"   8 minutes ago   Up 8 minutes   0.0.0.0:3306->3306/tcp   sse-fiuni_db_1

```
docker exec -it a1ab67e67d7e /bin/bash 
root@a1ab67e67d7e:/var/www/html# ls 
webserver
root@a1ab67e67d7e:/var/www/html# cd webserver/
root@a1ab67e67d7e:/var/www/html/webserver# php artisan migrate:install && php artisan migrate --seed
```

ir a : <http://localhost:8080/>
usuario: root
pass: example

#### crear db con nombre "sse" y agregar privilegios

GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';

## URLs utiles

Documentacion de Laravel: <https://laravel.com/docs/8.x>
Relaciones en migraciones: <https://stackoverflow.com/questions/26437342/laravel-migration-best-way-to-add-foreign-key/26437697>
<https://spatie.be/docs/laravel-permission/v5/introduction>
<https://docs.laravel-excel.com/3.1/imports/custom-csv-settings.html>
