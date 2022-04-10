<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

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


        // create roles and assign created permissions

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
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
        ]);

        $user->assignRole(User::ROLE_ADMINISTRADOR);

        //usuario - Egresado para pruebas
        $user = User::create([
                'name' => 'Egresado',
                'email' => 'egresado@gmail.com',
                'password' => bcrypt('egresado'),
        ]);
        $user->assignRole(User::ROLE_EGRESADO);

        //usuario - Empleador para pruebas
        $user = User::create([
                'name' => 'Empleador',
                'email' => 'empleador@gmail.com',
                'password' => bcrypt('empleador'),
        ]);
        //final de usuarios de prueba

        $user->assignRole(User::ROLE_EMPLEADOR);
    }
}
