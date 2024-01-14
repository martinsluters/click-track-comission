<?php

namespace App\Services\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\AffiliateRegistrationConversion;
use App\Models\User;

class ConversionService
{
    public function handleConversion(AffiliateCode $code_click_event, User $user)
    {
        $this->createRegistrationConversion($code_click_event, $user);
    }

    /**
     * Create a new affiliate registration conversion.
     *
     * @param AffiliateCode $affiliate_code
     * @param User $user
     * @return void
     */
    public function createRegistrationConversion(AffiliateCode $affiliate_code, User $user): void
    {
        $affiliate_registration_conversion = new AffiliateRegistrationConversion();
        $affiliate_registration_conversion->affiliate_code_id = $affiliate_code->id;
        $affiliate_registration_conversion->user_id = $user->id;
        $affiliate_registration_conversion->save();
    }

}
