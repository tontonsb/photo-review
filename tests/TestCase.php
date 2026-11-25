<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mcamara\LaravelLocalization\LaravelLocalization;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    protected string $locale = 'lv';

    protected function setUp(): void
    {
        // Routes get their locale prefix at boot, before any test request exists.
        putenv(LaravelLocalization::ENV_ROUTE_KEY.'='.$this->locale);

        parent::setUp();
    }

    protected function tearDown(): void
    {
        putenv(LaravelLocalization::ENV_ROUTE_KEY);

        parent::tearDown();
    }
}
