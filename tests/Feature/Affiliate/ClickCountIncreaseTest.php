<?php

namespace Tests\Feature\Affiliate;

use App\Models\User;

class ClickCountIncreaseTest extends ClickEventTestCase
{
    /**
     * Test that click count is increased in the denormalized table when a user clicks on an affiliate link.
     */
    public function testClickCountIsIncreased(): void
    {
        $this->assertDatabaseCount('denormalized_affiliate_code_clicks', 0);
        $this->assertDatabaseCount('affiliate_code_click_events', 0);

        $response = $this->get('/register?' . $this->query_var . '=' . $this->affiliate_code->code);

        $this->assertDatabaseCount('denormalized_affiliate_code_clicks', 1);
        $this->assertDatabaseCount('affiliate_code_click_events', 1);

        $this->assertDatabaseHas('denormalized_affiliate_code_clicks', [
            'affiliate_code_id' => $this->affiliate_code->id,
            'user_id' => $this->affiliate_account_user->id,
            'affiliate_code' => $this->affiliate_code->code,
            'clicks_count' => 1,
        ]);

        $this->assertDatabaseHas('affiliate_code_click_events', [
            'affiliate_code_id' => $this->affiliate_code->id,
        ]);
    }

    /**
     * Test that click count is increased in the denormalized table when a user clicks on an affiliate link when the entry already exists.
     */
    public function testClickCountIsIncreasedIfTheEntryAlreadyExists(): void
    {
        $this->assertDatabaseCount('denormalized_affiliate_code_clicks', 0);
        $this->assertDatabaseCount('affiliate_code_click_events', 0);

        $response = $this->get('/register?' . $this->query_var . '=' . $this->affiliate_code->code);

        $this->assertDatabaseCount('denormalized_affiliate_code_clicks', 1);
        $this->assertDatabaseCount('affiliate_code_click_events', 1);

        $response = $this->get('/register?' . $this->query_var . '=' . $this->affiliate_code->code);

        $this->assertDatabaseCount('affiliate_code_click_events', 2);


        $this->assertDatabaseHas('denormalized_affiliate_code_clicks', [
            'affiliate_code_id' => $this->affiliate_code->id,
            'user_id' => $this->affiliate_account_user->id,
            'affiliate_code' => $this->affiliate_code->code,
            'clicks_count' => 2,
        ]);
    }


}
