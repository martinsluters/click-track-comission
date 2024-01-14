<?php

namespace Tests\Feature\Affiliate;

use Illuminate\Support\Facades\Cookie;

class ClickEventCookieCreationTest extends ClickEventTestCase
{
    /**
    * Test that an event of guest visiting an affiliate link a cookie is created.
    */
    public function test_event_of_visiting_registration_page_with_affiliate_link_creates_cookie(): void
    {
        $response = $this->get('/');

        $response->assertCookieMissing($this->cookie_name);

        $response = $this->get('/?' . $this->query_var . '=' . $this->affiliate_code->code);

        $response->assertCookie($this->cookie_name);
    }
}
