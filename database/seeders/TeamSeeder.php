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
        // Example: Fetch a user to assign the team to
        $user = User::first();

        if ($user) {
            // Insert team data
            DB::table('teams')->insert([
                [
                    'user_id' => $user->id,
                    'name' => 'Team Alpha',
                    'personal_team' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $user->id,
                    'name' => 'Team Beta',
                    'personal_team' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        } else {
            $this->command->warn('No user found. Please create a user first.');
        }
    }
}
