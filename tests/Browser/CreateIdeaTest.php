<?php

use App\Models\User;

it('can create an idea', function () {
    $user = User::factory()->create();

    $this->browse(function ($browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/ideas')
            ->assertPathIs('/ideas')
            ->click('[data-test="create-idea-button"]')
            ->type('title', 'My Great Idea')
            ->type('description', 'This is a description of my great idea.')
            ->press('Create')
            ->assertPathIs('/ideas');
    });
});
