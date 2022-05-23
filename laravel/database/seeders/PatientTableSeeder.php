<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patient::create([
            'name' => 'Klaas Schoute',
            'date_of_birth' => '01-01-1995',
            'email' => 'klaas@ipmedth.nl',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
