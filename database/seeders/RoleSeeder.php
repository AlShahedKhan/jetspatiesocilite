<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            $role = Role::firstOrCreate(['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']]);

            // Assign permissions based on role
            if ($roleData['name'] === 'super-admin') {
                // Super Admin gets all permissions
                $role->syncPermissions(Permission::all());
            }

            if ($roleData['name'] === 'admin') {
                // Admin gets specific permissions
                $adminPermissions = [
                    'role_read',
                    'role_create',
                    'role_update',
                    'role_delete',
                    'permission_read',
                    'permission_create',
                    'permission_update',
                    'permission_delete',
                    'user_read',
                    'user_create',
                    'user_update',
                    'user_delete',
                ];
                $role->syncPermissions(Permission::whereIn('name', $adminPermissions)->get());
            }

            if ($roleData['name'] === 'staff') {
                // Staff gets read-only permissions
                $staffPermissions = [
                    'role_read',
                    'permission_read',
                    'user_read',
                ];
                $role->syncPermissions(Permission::whereIn('name', $staffPermissions)->get());
            }

            if ($roleData['name'] === 'user') {
                // User gets no permissions (optional)
                $role->syncPermissions([]);
            }
        }

        $this->command->info('Roles and permissions linked successfully.');
    }
}
