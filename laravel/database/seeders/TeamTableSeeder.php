<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create([
            'user_id' => 1,
            'name' => "RF Team",
            'personal_team' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
