<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testRoutesAreAlive(): void
    {
        $this->get('/')->assertOk();
        $this->get('photos')->assertOk();
        $this->get('photos/somephoto')->assertOk();
        $this->get('reviews')->assertOk();
        $this->post('reviews')->assertOk();
    }
}
