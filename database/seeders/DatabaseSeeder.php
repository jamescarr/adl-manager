<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private function createUser($name, $email, $isAdmin) {
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('password'), // Set a secure password
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $normalRole = Role::firstOrCreate(['name' => 'User']);
        $user->assignRole($isAdmin ? $adminRole : $normalRole);

        if ($isAdmin && class_exists(Team::class)) {
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
    }

    public function run()
    {
        // Create or get the Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // create non-admin user
        $this->createUser('Normal User', 'test@example.com', false);
        $this->createUser('Admin User', 'admin@example.com', true);


        // Output success message to the console
        $this->command->info('Admin user and Admin team created successfully!');
    }
}
