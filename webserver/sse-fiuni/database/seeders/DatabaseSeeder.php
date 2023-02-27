<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Carreras;
use App\Models\Laboral;

use App\Models\Encuestas;
use App\Models\Preguntas;
use App\Models\OpcionesPregunta;

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
        $ing_informatica = Carreras::create([
                'carrera' => 'Ingenieria Informatica'
        ]);

        $ing_electro = Carreras::create([
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
        $role->givePermissionTo(Permission::create(['name' => 'Administrar Administradores']));
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
                'nombre' => 'Administrador',
                'apellido' => 'FIUNI',
                'ci' => 0000001,
                'confirmado' => true,
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
        ]);

        $user->assignRole(User::ROLE_ADMINISTRADOR);
        //usuario - Egresado para pruebas
        $user = User::create([
                'nombre' => 'Lorena',
                'apellido' => 'Del Puerto',
                'ci' => 3456667,
                'confirmado' => true,
                'carrera_id' => $ing_informatica->id,
                'email' => 'loredelpuerto@gmail.com',
                'password' => bcrypt('egresado'),
        ]);

        $user->assignRole(User::ROLE_EGRESADO);

        //usuario - Empleador para pruebas
        $user = User::create([
                'nombre' => 'Alvaro',
                'apellido' => 'Mercado',
                'ci' => 3456664,
                'confirmado' => true,
                'carrera_id' => $ing_informatica->id,
                'email' => 'alvar01omer@gmail.com',
                'password' => bcrypt('egresado'),
        ]);

        $user->assignRole(User::ROLE_EGRESADO);

    }
}
