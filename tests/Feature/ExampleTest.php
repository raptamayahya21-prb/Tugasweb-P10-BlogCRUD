<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Root url redirects to posts and posts returns 200 OK.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/posts');

        $postsResponse = $this->get('/posts');
        $postsResponse->assertStatus(200);
    }
}
