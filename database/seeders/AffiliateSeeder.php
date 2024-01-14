<?php

namespace Database\Seeders;

use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\AffiliateCodeClickEvent;
use App\Models\Affiliate\AffiliateRegistrationConversion;
use App\Models\Affiliate\DenormalizedAffiliateCodeClick;
use App\Models\User;
use Illuminate\Database\Seeder;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1 affiliate accounts
        $affiliate_account_users = User::factory(1)->affiliate()->create();

        // Create 3 affiliate codes
        $affiliate_codes = AffiliateCode::factory(3)->recycle($affiliate_account_users)->create();

        // Some clicks on affiliate codes
        AffiliateCodeClickEvent::factory(500)->recycle($affiliate_codes)->create();

        // Some registered regular users via affiliate codes
        AffiliateRegistrationConversion::factory(10)->recycle($affiliate_codes)->create();

        // Insert denormalized data for the 1st affiliate code
        $click_count = AffiliateCodeClickEvent::where('affiliate_code_id', 1)->count();
        $conversion_count = AffiliateRegistrationConversion::where('affiliate_code_id', 1)->count();
        $affiliate_code = AffiliateCode::find(1);
        (new DenormalizedAffiliateCodeClick([
            'affiliate_code_id' => 1,
            'user_id' => 1,
            'affiliate_code' => $affiliate_code->code,
            'clicks_count' => $click_count,
            'conversions_count' => $conversion_count,
        ]))->save();
        ;

        // Insert denormalized data for the 2nd affiliate code
        $click_count = AffiliateCodeClickEvent::where('affiliate_code_id', 2)->count();
        $conversion_count = AffiliateRegistrationConversion::where('affiliate_code_id', 2)->count();
        $affiliate_code = AffiliateCode::find(2);
        (new DenormalizedAffiliateCodeClick([
            'affiliate_code_id' => 2,
            'user_id' => 1,
            'affiliate_code' => $affiliate_code->code,
            'clicks_count' => $click_count,
            'conversions_count' => $conversion_count,
        ]))->save();

        // Insert denormalized data for the 3rd affiliate code
        $click_count = AffiliateCodeClickEvent::where('affiliate_code_id', 3)->count();
        $conversion_count = AffiliateRegistrationConversion::where('affiliate_code_id', 3)->count();
        $affiliate_code = AffiliateCode::find(3);
        (new DenormalizedAffiliateCodeClick([
            'affiliate_code_id' => 3,
            'user_id' => 1,
            'affiliate_code' => $affiliate_code->code,
            'clicks_count' => $click_count,
            'conversions_count' => $conversion_count,
        ]))->save();

        // Some directly registered regular users
        User::factory(10)->create();
    }
}
