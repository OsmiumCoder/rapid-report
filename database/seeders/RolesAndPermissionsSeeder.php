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
        Permission::create(['name' => 'view all incidents']);
        Permission::create(['name' => 'view own incidents']);
        Permission::create(['name' => 'view assigned incidents']);

        // create roles and assign created permissions
        Role::create(['name' => 'admin'])
            ->givePermissionTo(['view all incidents']);

        Role::create(['name' => 'supervisor'])
            ->givePermissionTo(['view assigned incidents', 'view own incidents']);

        Role::create(['name' => 'user'])
            ->givePermissionTo(['view own incidents']);

        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
    }
}
