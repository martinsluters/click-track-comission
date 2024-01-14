<?php

namespace Tests\Feature\Affiliate;

use App\Models\Affiliate\AffiliateCodeClickEvent;
use App\Models\User;

class ConversionCountIncreaseTest extends ClickEventTestCase
{
    /**
     * Test that conversion count is increased in the denormalized table when a user registers via an affiliate link.
     */
    public function testConversionCountIsIncreased(): void
    {
        $response = $this->get('/?' . $this->query_var . '=' . $this->affiliate_code->code);

        $affiliate_code_click_event_instance = AffiliateCodeClickEvent::orderBy('id', 'desc')->first();
        $response = $this
            ->withCookie($this->cookie_name, $affiliate_code_click_event_instance->toJson())
            ->post('/register', [
           'name' => 'Test User',
           'email' => 'test@example.com',
           'password' => 'password',
           'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('denormalized_affiliate_code_clicks', [
            'affiliate_code_id' => $this->affiliate_code->id,
            'user_id' => $this->affiliate_account_user->id,
            'affiliate_code' => $this->affiliate_code->code,
            'conversions_count' => 1,
        ]);
    }

    /**
     * Test that conversion count is increased in the denormalized table when two users register via the same affiliate link.
     */
    public function testConversionCountIsIncreasedTwice(): void
    {
        $response = $this->get('/?' . $this->query_var . '=' . $this->affiliate_code->code);

        $affiliate_code_click_event_instance = AffiliateCodeClickEvent::orderBy('id', 'desc')->first();
        $response = $this
            ->withCookie($this->cookie_name, $affiliate_code_click_event_instance->toJson())
            ->post('/register', [
           'name' => 'Test User',
           'email' => 'test-user-1@example.com',
           'password' => 'password',
           'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('denormalized_affiliate_code_clicks', [
            'affiliate_code_id' => $this->affiliate_code->id,
            'user_id' => $this->affiliate_account_user->id,
            'affiliate_code' => $this->affiliate_code->code,
            'conversions_count' => 1,
        ]);

        $this->post('/logout');

        $response = $this
            ->withCookie($this->cookie_name, $affiliate_code_click_event_instance->toJson())
            ->post('/register', [
           'name' => 'Test User',
           'email' => 'test-user-2@example.com',
           'password' => 'password',
           'password_confirmation' => 'password',
        ]);


        $this->assertDatabaseHas('denormalized_affiliate_code_clicks', [
            'affiliate_code_id' => $this->affiliate_code->id,
            'user_id' => $this->affiliate_account_user->id,
            'affiliate_code' => $this->affiliate_code->code,
            'conversions_count' => 2,
        ]);
    }
}
