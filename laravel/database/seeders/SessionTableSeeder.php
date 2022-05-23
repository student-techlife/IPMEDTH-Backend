<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Session;

class SessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::create([
            'user_id' => 1,
            'patient_id' => 1,
            'date' => '01-08-2022',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
