<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

        // create permissions
        Permission::create(['name' => 'edit articles']);
        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'visitante']);
        $role->givePermissionTo(Permission::all());

        // or may be done by chaining
        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'egresado']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'empleador']);
        $role->givePermissionTo(Permission::all());



    }
}
