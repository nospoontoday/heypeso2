<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'user_type' => 'borrower',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'user_type' => 'borrower',
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