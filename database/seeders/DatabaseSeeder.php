<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use Carbon\Carbon;
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
            NotificationMessageSeeder::class,
        ]);

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
            'created_at' => now()->subDays(rand(0, 60)),
        ])->each(function (Incident $incident) use ($supervisor) {
            Investigation::factory()->create(['supervisor_id' => $supervisor->id, 'incident_id' => $incident->id]);
            RootCauseAnalysis::factory()->create(['supervisor_id' => $supervisor->id, 'incident_id' => $incident->id]);
        });

        Incident::factory(5)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
            'created_at' => now()->subDays(rand(7, 60)),
            'closed_at' => now(),
        ]);
        Incident::factory(2)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
            'closed_at' => now()->addDays(2)
        ]);
        Incident::factory(3)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
            'closed_at' => now()->addDays(8)
        ]);
        Incident::factory(6)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
            'closed_at' => now()->addDays(13)
        ]);
        Incident::factory(2)->hasComments(5)->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
            'closed_at' => now()->addWeeks(5)
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $admin->email,
            'created_at' => now()->subDays(rand(0, 60)),
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $supervisor->email,
            'created_at' => now()->subDays(rand(0, 60)),
        ]);

        Incident::factory(5)->create([
            'reporters_email' => $user->email,
            'created_at' => now()->subDays(rand(0, 60)),
        ]);
    }
}
