# SSE-FIUNI
Sistema de seguimiento de egresados FIUNI


## Instrucciones
```sh
git clone https://github.com/Alvar01o/SSE-FIUNI.git
cd SSE-FIUNI
docker-compose build
docker-compose up
```
Entrar en el servidor 

```sh
sh build.sh
```

## URLs utiles 
Documentacion de Laravel: https://laravel.com/docs/8.x
Relaciones en migraciones: https://stackoverflow.com/questions/26437342/laravel-migration-best-way-to-add-foreign-key/26437697

# Comandos utiles.

## Migraciones
 - php artisan make:migration <migrationName> (Crear migraciones)
 - php artisan migrate (correr migraciones)

## Modelos
 - php artisan make:model <ModelName> (Crear modelos)