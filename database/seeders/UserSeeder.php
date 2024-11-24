<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the user
        $user = User::create([
            'name' => 'Jon',
            'email' => 'jon@test.com',
            'password' => bcrypt('12345678'),
        ]);

        // Create a "superadmin" role
        $role = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'sanctum']);

        // Assign all permissions to the "superadmin" role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        // Assign the "superadmin" role to the user
        $user->assignRole($role);
    }
}
