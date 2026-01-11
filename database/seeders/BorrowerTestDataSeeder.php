<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowerTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create reputation scores for test users
        $borrower = \App\Models\User::firstOrCreate([
            'email' => 'borrower@example.com',
        ], [
            'name' => 'Test Borrower',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'user_type' => 'borrower',
        ]);

        $borrower->reputationScore()->updateOrCreate([], [
            'tier' => 'default',
            'score' => 0,
            'loans_completed' => 0,
        ]);

        // Get admin user id
        $admin = \App\Models\User::where('email', 'oliverjohnpr2013@gmail.com')->first();
        $adminId = $admin ? $admin->id : 1;

        // Create some loan offers
        \App\Models\LoanOffer::create([
            'lender_id' => $adminId,
            'borrower_tier' => 'default',
            'min_amount' => 1000,
            'max_amount' => 1500,
            'interest_rate' => 8.0,
            'duration_months' => 1,
            'available_slots' => 5,
            'cooldown_days' => 30,
            'status' => 'active',
        ]);

        \App\Models\LoanOffer::create([
            'lender_id' => $adminId,
            'borrower_tier' => 'building',
            'min_amount' => 2000,
            'max_amount' => 3000,
            'interest_rate' => 7.0,
            'duration_months' => 2,
            'available_slots' => 3,
            'cooldown_days' => 30,
            'status' => 'active',
        ]);
    }
}
