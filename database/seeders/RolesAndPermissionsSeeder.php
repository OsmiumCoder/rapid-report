<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'incidents.view']);

        // create roles and assign created permissions
        Role::create(['name' => 'admin'])
            ->givePermissionTo(['incidents.view']);

        Role::create(['name' => 'supervisor'])
            ->givePermissionTo(['incidents.view']);

        Role::create(['name' => 'user'])
            ->givePermissionTo(['incidents.view']);

        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
    }
}
