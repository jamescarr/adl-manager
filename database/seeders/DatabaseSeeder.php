<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create or get the Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Create the admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Set a secure password
            ]
        );

        // Assign the Admin role to the user
        $admin->assignRole($adminRole);

        // If you're using Jetstream Teams, create the Admin team
        if (class_exists(Team::class)) {
            // Create the Admin Team if it doesn't exist
            $adminTeam = Team::firstOrCreate(
                ['name' => 'Admin Team', 'user_id' => $admin->id],
                ['personal_team' => true]
            );

            // Attach the team to the admin user
            $admin->teams()->attach($adminTeam);

            // Set the current team
            $admin->current_team_id = $adminTeam->id;
            $admin->save();
        }

        // Output success message to the console
        $this->command->info('Admin user and Admin team created successfully!');
    }
}
