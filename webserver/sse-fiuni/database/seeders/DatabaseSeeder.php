<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Carreras;
use App\Models\Laboral;
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
        $ver_empresa_permiso = Permission::create(['name' => 'Ver Empresas']);
        $role->givePermissionTo($ver_empresa_permiso);
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Empleador']));
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Egresados']));

        //        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => User::ROLE_EGRESADO]);
        $role->givePermissionTo($ver_empresa_permiso);
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Perfil de Egresados']));
        $role->givePermissionTo(Permission::create(['name' => 'Completar Encuesta de Egresados']));


        $role = Role::create(['name' => User::ROLE_EMPLEADOR]);
        $role->givePermissionTo(Permission::create(['name' => 'Completar Encuesta de Empleador']));

        //usuario - administrador para pruebas
        $user = User::create([
                'nombre' => 'Admin',
                'apellido' => '#1',
                'ci' => 0000001,
                'confirmado' => true,
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
        ]);

        $user->assignRole(User::ROLE_ADMINISTRADOR);

        //usuario - Egresado para pruebas
        $user = User::create([
                'nombre' => 'Egresado',
                'apellido' => '#1',
                'ci' => 0000002,
                'confirmado' => true,
                'carrera_id' => $carrera1->id,
                'email' => 'egresado@gmail.com',
                'password' => bcrypt('egresado'),
        ]);

        $user->assignRole(User::ROLE_EGRESADO);

        //usuario - Empleador para pruebas
        $user = User::create([
                'nombre' => 'Empleador',
                'apellido' => '#1',
                'ci' => 0000003,
                'confirmado' => true,
                'email' => 'empleador@gmail.com',
                'password' => bcrypt('empleador'),
        ]);
        $user->assignRole(User::ROLE_EMPLEADOR);
        //final de usuarios de prueba
        echo "Creando Egresados de prueba!!.. \n";
        for ($i=0; $i < 30; $i++) {
            $FourDigitRandomNumber = rand(1231,9999);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Informatica - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera1->id,
                    'ci' => $FourDigitRandomNumber,
                    'email' => "egresado{$FourDigitRandomNumber}@informatica.com",
                    'token_invitacion' => base64_encode(bcrypt("egresado{$FourDigitRandomNumber}@informatica.com".time())),
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Electromecanica - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera2->id,
                    'ci' => $FourDigitRandomNumber,
                    'email' => "egresado{$FourDigitRandomNumber}@electro.com",
                    'token_invitacion' => base64_encode(bcrypt("egresado{$FourDigitRandomNumber}@electro.com".time())),
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);
            //usuario - Egresado para pruebas
            $user = User::create([
                    'nombre' => "Egresado de Civil - {$FourDigitRandomNumber}",
                    'apellido' => "#{$FourDigitRandomNumber}",
                    'carrera_id' => $carrera3->id,
                    'ci' => $FourDigitRandomNumber,
                    'email' => "egresado{$FourDigitRandomNumber}@civil.com",
                    'token_invitacion' => base64_encode(bcrypt("egresado{$FourDigitRandomNumber}@civil.com".time())),
                    'password' => bcrypt('egresado'),
            ]);
            $user->assignRole(User::ROLE_EGRESADO);

            //usuario - Empleador para pruebas
            $user = User::create([
                    'nombre' => base64_encode($FourDigitRandomNumber),
                    'apellido' => base64_encode($FourDigitRandomNumber),
                    'ci' => $FourDigitRandomNumber,
                    'confirmado' => true,
                    'email' => 'empleador'.$FourDigitRandomNumber.'@gmail.com',
                    'password' => bcrypt('empleador'),
            ]);
            $user->assignRole(User::ROLE_EMPLEADOR);
        }
        Laboral::create(['empresa' => 'inventiva']);
        Laboral::create(['empresa' => 'Integradevs']);
        Laboral::create(['empresa' => 'Borealis']);
        Laboral::create(['empresa' => 'MoV']);
    }
}
