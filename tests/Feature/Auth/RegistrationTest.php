<?php

use App\Models\ReferralCode;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    ReferralCode::create(['code' => '12345678']);

    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'borrower',
        'referral_code' => '12345678',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'user_type' => 'borrower',
    ]);
    $this->assertDatabaseHas('referral_codes', [
        'code' => '12345678',
        'used_by_user_id' => 1, // assuming first user
    ]);
});

test('new users can register as lender', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'lender@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'lender',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'Jane Doe',
        'email' => 'lender@example.com',
        'user_type' => 'lender',
    ]);
});

test('borrower registration fails with invalid referral code', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Borrower User',
        'email' => 'borrower@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'borrower',
        'referral_code' => 'INVALID8',
    ]);

    $response->assertSessionHasErrors('referral_code');
    $this->assertGuest();
});

test('same email cannot be used for different user types', function () {
    // Create existing user as borrower
    User::factory()->create([
        'name' => 'Borrower User',
        'email' => 'shared@example.com',
        'user_type' => 'borrower',
    ]);

    // Try to register same email as lender
    $response = $this->post(route('register.store'), [
        'name' => 'Lender User',
        'email' => 'shared@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'lender',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});