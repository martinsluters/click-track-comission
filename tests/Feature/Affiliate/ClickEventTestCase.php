<?php

namespace Tests\Feature\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

abstract class ClickEventTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Models\User
     */
    protected User $affiliate_account_user;

    /**
     * @var \App\Models\Affiliate\AffiliateCode
     */
    protected AffiliateCode $affiliate_code;

    /**
     * @var string
     */
    protected string $query_var;

    /**
     * @var string
     */
    protected string $cookie_name;

    /**
     * @var int
     */
    protected int $cookie_expiry_minutes;


    protected function setUp(): void
    {
        parent::setUp();
        $this->affiliate_account_user = User::factory(1)->affiliate()->create()->first();
        $this->affiliate_code = AffiliateCode::factory(1)->recycle($this->affiliate_account_user)->create()->first();
        $this->query_var = Config::get('affiliate.query_string_parameter');
        $this->cookie_name = Config::get('affiliate.cookie_name');
        $this->cookie_expiry_minutes = Config::get('affiliate.cookie_expiry_minutes');
    }

}
