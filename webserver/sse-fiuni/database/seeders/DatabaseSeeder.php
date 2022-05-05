<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Carreras;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //creacion de Carreras
        $carrera1 = Carreras::create([
                'carrera' => 'Ingenieria Informatica'
        ]);

        $carrera2 = Carreras::create([
                'carrera' => 'Ingenieria Electromecanica'
        ]);

        $carrera3 = Carreras::create([
                'carrera' => 'Ingenieria Civil'
        ]);

        $role = Role::create(['name' => 'visitante']);

        // roles y permisos
        $role = Role::create(['name' => User::ROLE_ADMINISTRADOR]);
        $role->givePermissionTo(Permission::create(['name' => 'Generar Reportes']));
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Empleador']));
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Egresados']));

        //        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => User::ROLE_EGRESADO]);
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Perfil de Egresados']));
        $role->givePermissionTo(Permission::create(['name' => 'Completar Encuesta de Egresados']));


        $role = Role::create(['name' => User::ROLE_EMPLEADOR]);
        $role->givePermissionTo(Permission::create(['name' => 'Completar Encuesta de Empleador']));

        //usuario - administrador para pruebas
        $user = User::create([
                'nombre' => 'Admin',
                'apellido' => '#1',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
        ]);

        $user->assignRole(User::ROLE_ADMINISTRADOR);

        //usuario - Egresado para pruebas
        $user = User::create([
                'nombre' => 'Egresado',
                'apellido' => '#1',
                'carrera_id' => $carrera1->id,
                'email' => 'egresado@gmail.com',
                'password' => bcrypt('egresado'),
        ]);

        $user->assignRole(User::ROLE_EGRESADO);

        //usuario - Empleador para pruebas
        $user = User::create([
                'nombre' => 'Empleador',
                'apellido' => '#1',
                'email' => 'empleador@gmail.com',
                'password' => bcrypt('empleador'),
        ]);
        //final de usuarios de prueba
        echo "Creando Egresados de prueba!!.. \n";
        for ($i=0; $i < 30; $i++) {
            $FourDigitRandomNumber = rand(1231,9999);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Informatica - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera1->id,
                    'email' => "egresado{$FourDigitRandomNumber}@informatica.com",
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Electromecanica - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera2->id,
                    'email' => "egresado{$FourDigitRandomNumber}@electro.com",
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Civil - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera3->id,
                    'email' => "egresado{$FourDigitRandomNumber}@civil.com",
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
        }
        $user->assignRole(User::ROLE_EMPLEADOR);
    }
}
