<?php

namespace Database\Seeders;

use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\AffiliateCodeClickEvent;
use App\Models\Affiliate\AffiliateRegistrationConversion;
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

        // Some directly registered regular users
        User::factory(10)->create();
    }
}
