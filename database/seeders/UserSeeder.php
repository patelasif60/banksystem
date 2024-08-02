<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'date_of_birth' => '2024-07-31',
            'password' => Hash::make('admin@123'),
            'user_type'=> 'Admin',
        ]);
    }
}
