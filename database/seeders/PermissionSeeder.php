<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'role_read'],
            ['name' => 'role_create'],
            ['name' => 'role_update'],
            ['name' => 'role_delete'],
            ['name' => 'permission_read'],
            ['name' => 'permission_create'],
            ['name' => 'permission_update'],
            ['name' => 'permission_delete'],
            ['name' => 'user_read'],
            ['name' => 'user_create'],
            ['name' => 'user_update'],
            ['name' => 'user_delete'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions seeded successfully.');
    }
}
