<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => config('admin.admin_name'),
            'email' => config('admin.admin_email'),
            'password' => Hash::make(config('admin.admin_password')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
