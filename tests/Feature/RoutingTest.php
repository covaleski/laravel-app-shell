<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoutingTest extends TestCase
{
    /**
     * Ensure the PWA home page is automatically routed.
     */
    public function test_the_pwa_home_page_exists(): void
    {
        $response = $this->get('/app');

        $response->assertStatus(200);
    }
}
