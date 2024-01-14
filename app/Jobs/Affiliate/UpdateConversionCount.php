<?php

namespace App\Jobs\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use App\Models\Affiliate\DenormalizedAffiliateCodeClick;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateConversionCount implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected AffiliateCode $affiliate_code)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $denormalized_data_instance = DenormalizedAffiliateCodeClick::where('affiliate_code_id', $this->affiliate_code->id)->first();

        if (is_null($denormalized_data_instance)) {
            $denormalized_data_instance = new DenormalizedAffiliateCodeClick();
            $denormalized_data_instance->affiliate_code_id = $this->affiliate_code->id;
            $denormalized_data_instance->user_id = $this->affiliate_code->user_id;
            $denormalized_data_instance->affiliate_code = $this->affiliate_code->code;
            $denormalized_data_instance->conversions_count = 1;
            $denormalized_data_instance->save();
            return;
        }

        $denormalized_data_instance->increment('conversions_count');
        $denormalized_data_instance->save();
    }
}
