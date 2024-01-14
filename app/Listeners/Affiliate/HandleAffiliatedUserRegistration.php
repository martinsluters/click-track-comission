<?php

namespace App\Listeners\Affiliate;

use Illuminate\Auth\Events\Registered;

class HandleAffiliatedUserRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {

    }
}
