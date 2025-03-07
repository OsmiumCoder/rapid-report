<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Seed the application's database for testing.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            NotificationMessageSeeder::class,
        ]);
    }
}
