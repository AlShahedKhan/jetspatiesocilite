<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Define roles to seed
        $roles = [
            ['name' => 'super-admin', 'guard_name' => 'sanctum'],
            ['name' => 'admin', 'guard_name' => 'sanctum'],
            ['name' => 'staff', 'guard_name' => 'sanctum'],
            ['name' => 'user', 'guard_name' => 'sanctum'],
        ];

        // Loop through each role and create it if it doesn't exist
        foreach ($roles as $roleData) {
            Role::firstOrCreate(['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']]);
        }

        $this->command->info('Roles seeded successfully.');
    }
}
