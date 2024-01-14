<?php

namespace App\Services\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\AffiliateCodeClickEvent;
use Illuminate\Http\Request;

class CodeClickService
{
    public function __construct(protected string $query_string_parameter)
    {

    }

    /**
     * Save the affiliate code click event from the request.
     *
     * @param Request $request
     * @return false|AffiliateCodeClickEvent
     */
    public function saveAffiliateCodeClickEventRequest(Request $request): false|AffiliateCodeClickEvent
    {
        // Bail if request does not have "aff" query parameter.
        if (!$request->has($this->query_string_parameter)) {
            return false;
        }

        // Bail if the "aff" query parameter is empty.
        if (empty($request->get($this->query_string_parameter))) {
            return false;
        }

        $affiliate_code = AffiliateCode::where('code', $request->get($this->query_string_parameter))->first();

        // Bail if the "aff" query parameter is not a valid affiliate code.
        if (is_null($affiliate_code)) {
            // Depending on our future needs we could throw an exception here and then cache it and log etc.
            // For simplicity, I will just return false.
            return false;
        }

        // Save the affiliate code click in the database.
        $affiliate_code_click = new AffiliateCodeClickEvent();
        $affiliate_code_click->affiliate_code_id = $affiliate_code->id;

        // Bail if the affiliate code click could not be saved.
        if (!$affiliate_code_click->save()) {
            // Depending on our future needs we could throw an exception here and then cache it and log etc.
            // For simplicity, I will just return false.
            return false;
        }

        return $affiliate_code_click->refresh();
    }
}
