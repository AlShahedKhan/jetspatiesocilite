<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to import the User model
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all users
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please create users first.');
            return;
        }

        // Iterate over each user and create teams
        foreach ($users as $user) {
            // Create a personal team for the user
            $teamId = DB::table('teams')->insertGetId([
                'user_id' => $user->id,
                'name' => $user->name . "'s Personal Team",
                'personal_team' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update the user's current_team_id
            $user->update(['current_team_id' => $teamId]);

            $this->command->info("Team created for user: {$user->name}");
        }
    }
}
