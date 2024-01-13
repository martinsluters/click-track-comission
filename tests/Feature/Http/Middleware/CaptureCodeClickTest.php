<?php

namespace Tests\Feature\Http\Middleware;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CaptureCodeClickTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a guest from an affiliate link is redirected to the register route.
     */
    public function test_guest_from_affiliate_link_is_redirected_to_register_route(): void
    {
        $response = $this->get('/?aff=123');
        $response->assertRedirect(route('register'));
    }

    /**
     * Test that a guest from an affiliate link is redirected to the register route with 302 HTTP status code.
     */
    public function test_guest_from_affiliate_link_is_redirected_to_register_route_with_302_http_status_code(): void
    {
        $response = $this->get('/?aff=123');
        $response->assertStatus(302);
    }

    /**
     * Test that an authenticated user from an affiliate link is also redirected to the register route as per requirements.
     */
    public function test_authenticated_user_from_affiliate_link_is_redirected_to_register_route(): void
    {
        $user = \App\Models\User::factory()->create();
        $response = $this->actingAs($user)->get('/?aff=123');
        $response->assertRedirect(route('register'));
    }

    /**
     * Test that a guest that is already in the register route is not redirected.
     */
    public function test_guest_in_register_route_is_not_redirected(): void
    {
        $response = $this->get(route('register', ['aff' => 123]));
        $response->assertOk();  // 200
    }
}
