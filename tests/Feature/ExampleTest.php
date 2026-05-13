<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_welcome_page_returns_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }
}
