<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Admin and User roles
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
    }
}
