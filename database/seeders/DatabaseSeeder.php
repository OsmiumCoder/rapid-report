<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@super.com',
        ])->assignRole(['super-admin']);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->assignRole('admin');

        $supervisor = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->assignRole('supervisor');

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->assignRole('user');

        Incident::factory(5)->create([
            'reporters_email' => $user->email,
            'supervisor_name' => $supervisor->name,
            'supervisor_id' => $supervisor->id,
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $user->email,
            'supervisor_name' => $admin->name,
            'supervisor_id' => $admin->id,
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $user->email,
            'supervisor_name' => $superAdmin->name,
            'supervisor_id' => $superAdmin,
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $superAdmin->email,
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $admin->email,
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $supervisor->email,
        ]);
    }
}
