<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

pest()
    ->use(RefreshDatabase::class)
    ->in('Feature', 'Unit');
