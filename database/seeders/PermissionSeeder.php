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
            ['name' => 'store users'],
            ['name' => 'Update users'],
            ['name' => 'view users'],
            ['name' => 'destroy users'],
        ];
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
