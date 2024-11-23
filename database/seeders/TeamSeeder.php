<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('team_user')->insert([
            [
                'team_id' => 1, // Replace with actual team ID
                'user_id' => 1, // Replace with actual user ID
                'role' => 'Owner', // Example role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_id' => 1, // Same team, different user
                'user_id' => 2,
                'role' => 'Member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'team_id' => 2, // Different team, different user
                'user_id' => 3,
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
