<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Admin and User roles
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);

        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'create users']);

        $role = Role::findByName('Admin');
        $role->givePermissionTo(['view users', 'edit users', 'delete users', 'create users']);
    }
}
