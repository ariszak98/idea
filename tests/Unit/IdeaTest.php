<?php


use App\Models\Idea;
use Illuminate\Database\Eloquent\Collection;

test('it belongs to a user', function () {

    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(\App\Models\User::class);
});



test('it can have steps', function () {

    $idea = Idea::factory()->create();

    $idea->steps()->create([
        'description' => 'Test step'
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});

