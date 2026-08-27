<?php

test('registration screen is disabled', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
});

test('new users cannot register through the web route', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertStatus(404);
});
