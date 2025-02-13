<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
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
        ])->syncRoles(['super-admin']);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@b.com',
        ])->syncRoles('admin');

        $supervisor = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@b.com',
        ])->syncRoles('supervisor');


        User::factory()->create([
            'name' => 'Supervisor A',
            'email' => 'supervisorA@b.com',
        ])->syncRoles('supervisor');

        User::factory()->create([
            'name' => 'Supervisor B',
            'email' => 'supervisorB@b.com',
        ])->syncRoles('supervisor');

        User::factory()->create([
            'name' => 'Supervisor C',
            'email' => 'supervisorC@b.com',
        ])->syncRoles('supervisor');

        User::factory()->create([
            'name' => 'Supervisor D',
            'email' => 'supervisorD@b.com',
        ])->syncRoles('supervisor');

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@b.com',
        ])->syncRoles('user');

        Incident::factory(5)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        Incident::factory(5)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ])->each(function (Incident $incident) {
            Investigation::factory()->create(['incident_id' => $incident->id]);
        });

        Incident::factory(5)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
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

        Incident::factory(5)->create([
            'reporters_email' => $user->email,
        ]);
    }
}
