<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard (kanban board)', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/')->assertStatus(200);
});

test('dashboard route redirects to root', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/dashboard')->assertRedirect('/');
});