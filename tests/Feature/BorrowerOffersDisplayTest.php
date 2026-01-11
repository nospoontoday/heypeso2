<?php

use App\Models\User;
use App\Models\ReputationScore;
use App\Models\LoanOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('default borrower sees only default offers', function () {
    // Create borrowers
    $defaultBorrower = User::factory()->create(['user_type' => 'borrower', 'email' => 'default@example.com']);
    $defaultBorrower->reputationScore()->create(['tier' => 'default']);

    $buildingBorrower = User::factory()->create(['user_type' => 'borrower', 'email' => 'building@example.com']);
    $buildingBorrower->reputationScore()->create(['tier' => 'building']);

    // Create offers
    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'default',
        'min_amount' => 1000,
        'max_amount' => 1500,
        'interest_rate' => 8.0,
        'duration_months' => 1,
        'available_slots' => 5,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'building',
        'min_amount' => 2000,
        'max_amount' => 2500,
        'interest_rate' => 7.0,
        'duration_months' => 2,
        'available_slots' => 4,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    // Test default borrower
    $this->actingAs($defaultBorrower);
    $component = app(\App\Livewire\Borrower\BrowseOffers::class);
    $offers = $component->offers;

    expect($offers)->toHaveCount(1);
    expect($offers->first()->borrower_tier)->toBe('default');
});

test('building borrower sees only building offers', function () {
    $buildingBorrower = User::factory()->create(['user_type' => 'borrower']);
    $buildingBorrower->reputationScore()->create(['tier' => 'building']);

    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'default',
        'min_amount' => 1000,
        'max_amount' => 1500,
        'interest_rate' => 8.0,
        'duration_months' => 1,
        'available_slots' => 5,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'building',
        'min_amount' => 2000,
        'max_amount' => 2500,
        'interest_rate' => 7.0,
        'duration_months' => 2,
        'available_slots' => 4,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    $this->actingAs($buildingBorrower);
    $component = app(\App\Livewire\Borrower\BrowseOffers::class);
    $offers = $component->offers;

    expect($offers)->toHaveCount(1);
    expect($offers->first()->borrower_tier)->toBe('building');
});

test('premium borrower sees premium offers', function () {
    $premiumBorrower = User::factory()->create(['user_type' => 'borrower']);
    $premiumBorrower->reputationScore()->create(['tier' => 'premium']);

    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'default',
        'min_amount' => 1000,
        'max_amount' => 1500,
        'interest_rate' => 8.0,
        'duration_months' => 1,
        'available_slots' => 5,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'premium',
        'min_amount' => 5000,
        'max_amount' => 10000,
        'interest_rate' => 4.0,
        'duration_months' => 6,
        'available_slots' => 2,
        'cooldown_days' => 30,
        'status' => 'active',
        'is_premium_offer' => true,
    ]);

    $this->actingAs($premiumBorrower);
    $component = app(\App\Livewire\Borrower\BrowseOffers::class);
    $offers = $component->offers;

    expect($offers)->toHaveCount(1);
    expect($offers->first()->borrower_tier)->toBe('premium');
});

test('offers respect amount and rate limits', function () {
    $buildingBorrower = User::factory()->create(['user_type' => 'borrower']);
    $buildingBorrower->reputationScore()->create(['tier' => 'building']);

    // Valid offer
    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'building',
        'min_amount' => 2000,
        'max_amount' => 3000, // Within 3500 limit
        'interest_rate' => 7.0, // Within 5-10 range
        'duration_months' => 2,
        'available_slots' => 4,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    // Invalid offer (amount too high)
    LoanOffer::create([
        'lender_id' => 1,
        'borrower_tier' => 'building',
        'min_amount' => 2000,
        'max_amount' => 4000, // Over 3500 limit
        'interest_rate' => 7.0,
        'duration_months' => 2,
        'available_slots' => 4,
        'cooldown_days' => 30,
        'status' => 'active',
    ]);

    $this->actingAs($buildingBorrower);
    $component = app(\App\Livewire\Borrower\BrowseOffers::class);
    $offers = $component->offers;

    expect($offers)->toHaveCount(1);
    expect($offers->first()->max_amount)->toEqual(3000);
});
