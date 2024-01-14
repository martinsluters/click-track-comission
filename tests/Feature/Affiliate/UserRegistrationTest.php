<?php

namespace Tests\Feature\Affiliate;

use App\Models\Affiliate\AffiliateCodeClickEvent;
use App\Models\Affiliate\AffiliateRegistrationConversion;
use App\Models\User;

class UserRegistrationTest extends ClickEventTestCase
{
    /**
     * Test that user is has relation with affiliate code if cookie/click event is present when registering.
     */
    public function test_user_is_has_relation_with_affiliate_code_if_cookie_click_event_is_present_when_registering(): void
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
        $user = User::where('email', 'test@example.com')->first();

        $conversion = AffiliateRegistrationConversion::where('user_id', $user->id)
                ->where('affiliate_code_id', $affiliate_code_click_event_instance->affiliate_code_id)
                ->exists();

        $this->assertTrue($conversion);
    }


}
