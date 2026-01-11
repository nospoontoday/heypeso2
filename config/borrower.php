<?php

return [
    'loan_limits' => [
        'default' => env('DEFAULT', 2000),
        'building' => env('BUILDING', 3500),
        'reliable' => env('RELIABLE', 5000),
        'premium' => env('PREMIUM', 25000),
    ],
    'recommended_interest_rates' => [
        'default' => [
            'min' => env('DEFAULT_INTEREST_RATE_MIN', 5.0),
            'max' => env('DEFAULT_INTEREST_RATE_MAX', 10.0),
        ],
        'building' => [
            'min' => env('BUILDING_INTEREST_RATE_MIN', 5.0),
            'max' => env('BUILDING_INTEREST_RATE_MAX', 10.0),
        ],
        'reliable' => [
            'min' => env('RELIABLE_INTEREST_RATE_MIN', 5.0),
            'max' => env('RELIABLE_INTEREST_RATE_MAX', 8.0),
        ],
        'premium' => [
            'min' => env('PREMIUM_INTEREST_RATE_MIN', 3.0),
            'max' => env('PREMIUM_INTEREST_RATE_MAX', 6.0),
        ],
    ],
    'max_durations' => [
        'default' => env('DEFAULT_MAX_DURATION_MONTHS', 2),
        'building' => env('BUILDING_MAX_DURATION_MONTHS', 3),
        'reliable' => env('RELIABLE_MAX_DURATION_MONTHS', 5),
        'premium' => env('PREMIUM_MAX_DURATION_MONTHS', 12),
    ],
    'tier_badges' => [
        'default' => [
            'name' => 'New Borrower',
            'emoji' => '🔴',
            'color' => 'red',
            'description' => 'First-time borrower',
        ],
        'building' => [
            'name' => 'Building Trust',
            'emoji' => '🟡',
            'color' => 'yellow',
            'description' => 'Established borrower',
        ],
        'reliable' => [
            'name' => 'Reliable',
            'emoji' => '🟢',
            'color' => 'green',
            'description' => 'Highly trusted borrower',
        ],
        'premium' => [
            'name' => 'Premium',
            'emoji' => '💎',
            'color' => 'purple',
            'description' => 'Elite borrower',
        ],
    ],
    'safety_controls' => [
        'max_active_loans_per_borrower' => env('MAX_ACTIVE_LOANS_PER_BORROWER', 1),
        'cooldown_days_after_late_payment' => env('COOLDOWN_DAYS_AFTER_LATE_PAYMENT', 30),
        'auto_downgrade_on_missed_payment' => env('AUTO_DOWNGRADE_ON_MISSED_PAYMENT', true),
        'premium_late_payment_grace_days' => env('PREMIUM_LATE_PAYMENT_GRACE_DAYS', 3),
        'auto_default_after_missed_installments' => env('AUTO_DEFAULT_AFTER_MISSED_INSTALLMENTS', 3),
        'grace_period_days' => [
            'default' => env('DEFAULT_GRACE_PERIOD_DAYS', 0),
            'building' => env('BUILDING_GRACE_PERIOD_DAYS', 0),
            'reliable' => env('RELIABLE_GRACE_PERIOD_DAYS', 1),
            'premium' => env('PREMIUM_GRACE_PERIOD_DAYS', 3),
        ],
    ],
];