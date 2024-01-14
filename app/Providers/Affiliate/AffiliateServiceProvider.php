<?php

namespace App\Providers\Affiliate;

use App\Services\Affiliate\ConversionService;
use App\Services\Affiliate\CookieService;
use App\Services\Affiliate\CodeClickService;
use Illuminate\Support\ServiceProvider;

class AffiliateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CodeClickService::class, function ($app) {
            return new CodeClickService(config('affiliate.query_string_parameter'));
        });

        $this->app->singleton(CookieService::class, function ($app) {
            return new CookieService(
                config('affiliate.cookie_name'),
                config('affiliate.cookie_expiry_minutes')
            );
        });

        $this->app->singleton(ConversionService::class, function ($app) {
            return new ConversionService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
