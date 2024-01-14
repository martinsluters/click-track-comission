<?php

namespace App\Jobs\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\AffiliateCodeClickEvent;
use App\Models\Affiliate\DenormalizedAffiliateCodeClick;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateClickCount implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected AffiliateCodeClickEvent $affiliate_code_click_event)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $denormalized_data_instance = DenormalizedAffiliateCodeClick::where('affiliate_code_id', $this->affiliate_code_click_event->affiliate_code_id)->first();

        if (is_null($denormalized_data_instance)) {
            $affiliate_code = AffiliateCode::find($this->affiliate_code_click_event->affiliate_code_id);

            if(is_null($affiliate_code)) {
                // Nothing to increase then.
                return;
            }

            $denormalized_data_instance = new DenormalizedAffiliateCodeClick();
            $denormalized_data_instance->affiliate_code_id = $affiliate_code->id;
            $denormalized_data_instance->user_id = $affiliate_code->user_id;
            $denormalized_data_instance->affiliate_code = $affiliate_code->code;
            $denormalized_data_instance->clicks_count = 1;
            $denormalized_data_instance->save();
            return;
        }

        $denormalized_data_instance->increment('clicks_count');
        $denormalized_data_instance->save();
    }
}
