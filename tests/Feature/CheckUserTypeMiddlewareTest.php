<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated users are redirected to login', function () {
    $response = $this->get(route('test.lender'));

    $response->assertRedirect(route('login'));
});

test('users with wrong type get 403', function () {
    $user = User::factory()->create(['user_type' => 'borrower']);

    $response = $this->actingAs($user)->get(route('test.lender'));

    $response->assertStatus(403);
});

test('users with correct type can access', function () {
    $user = User::factory()->create(['user_type' => 'lender']);

    $response = $this->actingAs($user)->get(route('test.lender'));

    $response->assertStatus(200);
});
