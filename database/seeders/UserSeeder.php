<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('12345678'),
        ]);

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'sanctum']);
        $superAdminPermission = Permission::all();
        $superAdminRole->syncPermissions($superAdminPermission);
        $superAdmin->assignRole($superAdminRole);

        // Create the admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('12345678'),
        ]);

        // Create the "admin" role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'sanctum']);

        // Assign all permissions to the "admin" role
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);

        // Assign the "admin" role to the admin user
        $admin->assignRole($adminRole);

        // Create a staff
        $staff = User::create([
            'name' => 'staff',
            'email' => 'staff@test.com',
            'password' => bcrypt('12345678'),
        ]);

        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'sanctum']);
        $staffPermission = Permission::all()->except([
            'role_create',
            'role_update',
            'role_delete',
            'permission_create',
            'permission_update',
            'permission_delete',
            'user_create',
            'user_update',
            'user_delete',
        ]);
        $staffRole->syncPermissions($staffPermission);
        $staff->assignRole($staffRole);

        // Create a regular user
        $user = User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => bcrypt('12345678'),
        ]);

        // Create the "user" role
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'sanctum']);

        // Assign all admin permissions to the "user" role
        $userRole->syncPermissions($adminRole->permissions);

        // Assign the "user" role to the user
        $user->assignRole($userRole);

        // Create a team for the regular user
        $teamId = DB::table('teams')->insertGetId([
            'user_id' => $user->id,
            'name' => 'User Team',
            'personal_team' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign the created team to the user's current_team_id
        $user->update(['current_team_id' => $teamId]);

        $this->command->info('Admin and User seeded with appropriate permissions and teams.');
    }
}
