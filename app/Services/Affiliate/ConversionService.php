<?php

namespace App\Services\Affiliate;

use App\Jobs\Affiliate\UpdateConversionCount;
use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\AffiliateRegistrationConversion;
use App\Models\User;

class ConversionService
{
    public function handleConversion(AffiliateCode $code_click_event, User $user)
    {
        $conversion_instance = $this->createRegistrationConversion($code_click_event, $user);
        if(! is_null($conversion_instance)) {
            $this->updateConversionCount($code_click_event);
        }
    }

    /**
     * Create a new affiliate registration conversion.
     *
     * @param AffiliateCode $affiliate_code
     * @param User $user
     * @return void
     */
    public function createRegistrationConversion(AffiliateCode $affiliate_code, User $user): ?AffiliateRegistrationConversion
    {
        $affiliate_registration_conversion = new AffiliateRegistrationConversion();
        $affiliate_registration_conversion->affiliate_code_id = $affiliate_code->id;
        $affiliate_registration_conversion->user_id = $user->id;
        $affiliate_registration_conversion->save();
        return $affiliate_registration_conversion;
    }

    private function updateConversionCount(AffiliateCode $affiliate_code)
    {
        UpdateConversionCount::dispatch($affiliate_code);
    }

}
