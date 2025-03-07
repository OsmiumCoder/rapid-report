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

        Permission::firstOrCreate(['name' => 'view all incidents']);
        Permission::firstOrCreate(['name' => 'view own incidents']);
        Permission::firstOrCreate(['name' => 'view assigned incidents']);
        Permission::firstOrCreate(['name' => 'perform admin actions']);
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'provide incident follow-up']);
        Permission::firstOrCreate(['name' => 'view any incident follow-up']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'add comments']);
        Permission::firstOrCreate(['name' => 'download any files']);
        Permission::firstOrCreate(['name' => 'download files']);
        Permission::firstOrCreate(['name' => 'download own files']);

        Role::firstOrCreate(['name' => 'admin'])
            ->syncPermissions([
                'view all incidents',
                'view own incidents',
                'perform admin actions',
                'view reports',
                'view any incident follow-up',
                'manage users',
                'add comments',
                'download any files',
            ]);

        Role::firstOrCreate(['name' => 'supervisor'])
            ->syncPermissions([
                'view assigned incidents',
                'view own incidents',
                'provide incident follow-up',
                'add comments',
                'download files',
            ]);

        Role::firstOrCreate(['name' => 'user'])
            ->syncPermissions([
                'view own incidents',
                'download own files',
            ]);
    }
}
