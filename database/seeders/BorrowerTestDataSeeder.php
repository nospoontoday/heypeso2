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
        // Create borrowers for each tier
        $tiers = ['default', 'building', 'reliable', 'premium'];
        $borrowers = [];

        foreach ($tiers as $tier) {
            $borrower = \App\Models\User::firstOrCreate([
                'email' => $tier . '@example.com',
            ], [
                'name' => ucfirst($tier) . ' Borrower',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'borrower',
            ]);

            $borrower->reputationScore()->updateOrCreate([], [
                'tier' => $tier,
                'score' => 10 * array_search($tier, $tiers), // Increasing score
                'loans_completed' => array_search($tier, $tiers),
            ]);

            $borrowers[$tier] = $borrower;
        }

        // Get admin user id
        $admin = \App\Models\User::where('email', 'oliverjohnpr2013@gmail.com')->first();
        $adminId = $admin ? $admin->id : 1;

        // Create loan offers for each tier with variations
        $offers = [
            [
                'borrower_tier' => 'default',
                'min_amount' => 1000,
                'max_amount' => 1500,
                'interest_rate' => 8.0,
                'monthly_fee' => 10,
                'duration_months' => 1,
                'available_slots' => 5,
            ],
            [
                'borrower_tier' => 'default',
                'min_amount' => 1200,
                'max_amount' => 1800,
                'interest_rate' => 9.0,
                'monthly_fee' => 15,
                'duration_months' => 2,
                'available_slots' => 3,
            ],
            [
                'borrower_tier' => 'building',
                'min_amount' => 2000,
                'max_amount' => 2500,
                'interest_rate' => 7.0,
                'monthly_fee' => 20,
                'duration_months' => 2,
                'available_slots' => 4,
            ],
            [
                'borrower_tier' => 'building',
                'min_amount' => 2200,
                'max_amount' => 3000,
                'interest_rate' => 6.5,
                'monthly_fee' => 25,
                'duration_months' => 3,
                'available_slots' => 2,
            ],
            [
                'borrower_tier' => 'reliable',
                'min_amount' => 3000,
                'max_amount' => 4000,
                'interest_rate' => 6.0,
                'monthly_fee' => 30,
                'duration_months' => 3,
                'available_slots' => 3,
            ],
            [
                'borrower_tier' => 'reliable',
                'min_amount' => 3500,
                'max_amount' => 4500,
                'interest_rate' => 5.5,
                'monthly_fee' => 35,
                'duration_months' => 4,
                'available_slots' => 2,
            ],
            [
                'borrower_tier' => 'premium',
                'min_amount' => 5000,
                'max_amount' => 10000,
                'interest_rate' => 4.0,
                'monthly_fee' => 40,
                'duration_months' => 6,
                'available_slots' => 2,
            ],
            [
                'borrower_tier' => 'premium',
                'min_amount' => 8000,
                'max_amount' => 15000,
                'interest_rate' => 3.5,
                'monthly_fee' => 45,
                'duration_months' => 8,
                'available_slots' => 1,
                'is_premium_offer' => true,
            ],
        ];

        foreach ($offers as $offerData) {
            \App\Models\LoanOffer::create(array_merge($offerData, [
                'lender_id' => $adminId,
                'cooldown_days' => 30,
                'status' => 'active',
            ]));
        }
    }
}
