<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        //$response = $this->get('/register')->assertStatus(404);

        //$this->assertDatabaseCount('users', 0);

        $this->assertDatabaseMissing('users', [
            'email' => 'sally@example.com',
        ]);

    }
}
