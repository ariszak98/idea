<?php

use App\Models\User;

it('can register', function () {
    $this->browse(function ($browser) {
        $browser->visit('/register')
            ->type('name', 'John')
            ->type('email', fake()->unique()->safeEmail())
            ->type('password', 'password123')
            ->press('Create Account')
            ->waitForLocation('/')
            ->assertPathIs('/')
            ->assertAuthenticated();
    });

});

it('can logout', function () {

    $user = User::factory()->create();
    Auth::login($user);
    $this->assertAuthenticated();

    $this->browse(function ($browser) {
        $browser->visit('/')
            ->press('Log Out')
            ->waitForLocation('/')
            ->assertPathIs('/')
            ->assertGuest();
    });

});

it('cannot register with an existing email', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
    ]);

    $this->browse(function ($browser) {
        $browser->visit('/register')
            ->type('name', 'John')
            ->type('email', 'jane@example.com')
            ->type('password', 'password123')
            ->press('Create Account')
            ->waitForLocation('/register')
            ->assertPathIs('/register')
            ->assertSee('The email has already been taken.');
    });
});

it('cannot register with a short password', function () {

    $this->browse(function ($browser) {
        $browser->visit('/register')
            ->type('name', 'John')
            ->type('email', fake()->unique()->safeEmail())
            ->type('password', 'aa')
            ->press('Create Account')
            ->waitForLocation('/register')
            ->assertPathIs('/register')
            ->assertSee('must be');
    });
});
