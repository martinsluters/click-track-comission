<?php

namespace App\Models\Affiliate;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DenormalizedAffiliateCodeClick extends Model
{
    // No timestamps
    public $timestamps = false;

    /**
     * @param User $user
     * @return array
     *
     * @TODO returning array is ugly, in future we should return a dedicated type.
     */
    public static function getStatisticalDataByUser(User $user): array
    {
        $user_statistical_data = DenormalizedAffiliateCodeClick::where('user_id', $user->id)->limit(50)->get();
        $data = [
            'labels' => [],
            'click_count_data' => [],
            'conversions_count_data' => [],
            'conversion_ratio_data' => [],
        ];
        if ($user_statistical_data->count() > 0) {
            $data['labels'] = $user_statistical_data->pluck('affiliate_code')->toArray();
            $data['click_count_data'] = $user_statistical_data->pluck('clicks_count')->toArray();
            $data['conversions_count_data'] = $user_statistical_data->pluck('conversions_count')->toArray();
            $data['conversion_ratio_data'] = array_map(function ($clicks, $conversions) {
                return $conversions / $clicks;
            }, $data['click_count_data'], $data['conversions_count_data']);
        }

        return $data;
    }

}
