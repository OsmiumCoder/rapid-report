<?php

namespace Database\Seeders;

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
        Permission::firstOrCreate(['name' => 'view all incidents']);
        Permission::firstOrCreate(['name' => 'view own incidents']);
        Permission::firstOrCreate(['name' => 'view assigned incidents']);
        Permission::firstOrCreate(['name' => 'perform admin actions']);
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'provide investigations']);
        Permission::firstOrCreate(['name' => 'view any investigation']);
        Permission::firstOrCreate(['name' => 'manage users']);


        // create roles and assign created permissions
        Role::firstOrCreate(['name' => 'admin'])
            ->syncPermissions([
                'view all incidents',
                'view own incidents',
                'perform admin actions',
                'view reports',
                'view any investigation',
                'manage users',
            ]);

        Role::firstOrCreate(['name' => 'supervisor'])
            ->syncPermissions([
                'view assigned incidents',
                'view own incidents',
                'provide investigations'
            ]);

        Role::firstOrCreate(['name' => 'user'])
            ->syncPermissions([
                'view own incidents'
            ]);

        Role::firstOrCreate(['name' => 'super-admin'])
            ->syncPermissions(Permission::all());
    }
}
