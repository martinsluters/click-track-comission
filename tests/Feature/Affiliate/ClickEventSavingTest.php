<?php

namespace Tests\Feature\Affiliate;

use App\Models\Affiliate\AffiliateCodeClickEvent;
use App\Models\User;

class ClickEventSavingTest extends ClickEventTestCase
{
    /**
     * Test that an event of guest visiting registration page or other page without an affiliate link is not saved.
     */
    public function test_event_of_visiting_registration_page_without_affiliate_link_is_not_saved(): void
    {
        $this->assertDatabaseCount('affiliate_code_click_events', 0);
        $response = $this->get('/register');
        $response = $this->get('/');
        $this->assertDatabaseCount('affiliate_code_click_events', 0);
    }

    /**
     * Test that an event of guest visiting registration page with an affiliate link is saved.
     */
    public function test_event_of_visiting_registration_page_with_affiliate_link_is_saved(): void
    {
        $this->assertDatabaseCount('affiliate_code_click_events', 0);
        $response = $this->get('/register?' . $this->query_var . '=' . $this->affiliate_code->code);
        $this->assertDatabaseCount('affiliate_code_click_events', 1);

        // Assert that the affiliate code click events table contains the entry with the affiliate id.
        $this->assertTrue(AffiliateCodeClickEvent::where('affiliate_code_id', $this->affiliate_code->id)->exists());

    }

    /**
     * Test that an event of authenticated user visiting registration page with an affiliate link is saved.
     */
    public function test_event_of_auth_user_visiting_registration_page_with_affiliate_link_is_saved(): void
    {

        $user = \App\Models\User::factory()->create();

        $this->assertDatabaseCount('affiliate_code_click_events', 0);
        $response = $this->actingAs($user)->get('/register?' . $this->query_var . '=' . $this->affiliate_code->code);
        $this->assertDatabaseCount('affiliate_code_click_events', 1);

        // Assert that the affiliate code click events table contains the entry with the affiliate id.
        $this->assertTrue(AffiliateCodeClickEvent::where('affiliate_code_id', $this->affiliate_code->id)->exists());
    }

    /**
     * Test that multiple affiliate link clicks lead to individual events saved in database.
     */
    public function test_multiple_affiliate_link_clicks_lead_to_individual_events_saved_in_database(): void
    {
        $this->assertDatabaseCount('affiliate_code_click_events', 0);
        $response = $this->get('/?' . $this->query_var . '=' . $this->affiliate_code->code);
        $this->assertDatabaseCount('affiliate_code_click_events', 1);

        $response = $this->get('/register?' . $this->query_var . '=' . $this->affiliate_code->code);
        $this->assertDatabaseCount('affiliate_code_click_events', 2);

        $response = $this->get('/?' . $this->query_var . '=' . $this->affiliate_code->code);
        $this->assertDatabaseCount('affiliate_code_click_events', 3);
    }

    /**
     * Test that an event of guest visiting registration page or other page without with an affiliate link which value is not in database is not saved.
     */
    public function test_event_of_visiting_registration_page_with_affiliate_link_which_value_is_not_in_database_is_not_saved(): void
    {
        $this->assertDatabaseCount('affiliate_code_click_events', 0);
        $response = $this->get('/register?' . $this->query_var . '=non-existing-affiliate-code');
        $this->assertDatabaseCount('affiliate_code_click_events', 0);
    }

}
