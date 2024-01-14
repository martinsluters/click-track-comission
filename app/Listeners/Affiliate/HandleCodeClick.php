<?php

namespace App\Listeners\Affiliate;

use App\Events\Affiliate\CodeClickCaptured;
use App\Services\Affiliate\CodeClickService;
use App\Services\Affiliate\CookieService;

class HandleCodeClick
{
    /**
     * Create the event listener.
     *
     * @param CookieService $affiliateCodeClickCookieService
     * @param CodeClickService $affiliateCodeClickService
     */
    public function __construct(
        protected CookieService             $affiliateCodeClickCookieService,
        protected CodeClickService $affiliateCodeClickService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CodeClickCaptured $event): void
    {

        $click_event = $this->affiliateCodeClickService->saveAffiliateCodeClickEventRequest($event->request);

        // Bail if the affiliate code click event could not be saved. We could throw an exception in the service cache it here and log etc.
        if (false === $click_event) {
            return;
        }

        // Set the affiliate cookie with the click event. We could throw an exception in the service cache it here and log etc.
        $this->affiliateCodeClickCookieService->setAffiliateCookieWithClickEvent($click_event);
    }
}
