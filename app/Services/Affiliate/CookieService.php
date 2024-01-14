<?php

namespace App\Services\Affiliate;

use App\Models\Affiliate\AffiliateCodeClickEvent;
use Illuminate\Support\Facades\Cookie;

class CookieService
{
    public function __construct(protected string $cookie_name, protected int $cookie_expiry_minutes)
    {

    }

    /**
     * Set the affiliate cookie with the given click event.
     *
     * @param AffiliateCodeClickEvent $affiliate_click_event
     * @return void
     */
    public function setAffiliateCookieWithClickEvent(AffiliateCodeClickEvent $affiliate_click_event): void
    {
        try {
            $value = $affiliate_click_event->toJson();
            cookie()->queue($this->cookie_name, $value, $this->cookie_expiry_minutes);
        } catch (\Exception $e) {
            // Do something here if we need to. Maybe log.
        }
    }

    /**
     * Get affiliate code ID from affiliate cookie.
     *
     * @return int|null
     */
    public function getAffiliateCodeIDFromCookie(): ?int
    {
        $cookie_value = Cookie::get($this->cookie_name);

        if (false === $cookie_value) {
            return null;
        }

        try {
            $click_event_array = \json_decode($cookie_value, true);
        } catch (\Exception $e) {
            // Corrupted JSON
            return null;
        }

        if (! is_array($click_event_array)) {
            // Corrupted JSON
            return null;
        }

        if (! \array_key_exists('affiliate_code_id', $click_event_array)) {
            // Corrupted JSON, ID is missing
            return null;
        }

        return (int) $click_event_array['affiliate_code_id'];
    }
}
