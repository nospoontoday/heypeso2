<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'oliverjohnpr2013@gmail.com'],
            [
                'name' => 'Oliver Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'lender',
                'is_admin' => true,
                'email_verified_at' => time_now(),
            ]
        );
    }
}
