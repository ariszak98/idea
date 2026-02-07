<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DuskTestCase;
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');
uses(DuskTestCase::class)->in('Browser');

pest()
    ->use(RefreshDatabase::class)
    ->in('Feature', 'Unit', 'Browser');
