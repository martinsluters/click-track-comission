<?php

namespace App\Listeners\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use App\Services\Affiliate\ConversionService;
use App\Services\Affiliate\CookieService;
use Illuminate\Auth\Events\Registered;

class HandleAffiliatedUserRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct(protected CookieService $affiliateCodeClickCookieService, protected ConversionService $affiliateConversionService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $affiliate_code_id = $this->affiliateCodeClickCookieService->getAffiliateCodeIDFromCookie();

        if (is_null($affiliate_code_id)) {
            return;
        }

        $affiliate_code = AffiliateCode::where('id', $affiliate_code_id)->first();

        if (is_null($affiliate_code)) {
            return;
        }

        $this->affiliateConversionService->handleConversion($affiliate_code, $event->user);
    }
}
