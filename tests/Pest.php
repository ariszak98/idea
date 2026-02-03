<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class)->in('Feature', 'Unit');


pest()
    ->use(RefreshDatabase::class)
    ->in('Feature', 'Unit');
