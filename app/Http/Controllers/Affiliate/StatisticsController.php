<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Affiliate\DenormalizedAffiliateCodeClick;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Display default statistics view.
     */
    public function index(): View
    {
        // Provide all Users models to the view
        return view('affiliate.affiliates-list', [
            'users' => User::where('is_affiliate', true)->paginate(10),
        ]);
    }

    /**
     * Display graphical statistics view.
     */
    public function graphical(User $user): View
    {
        if (! $user->is_affiliate) {
            abort(404);
        }

        $statistical_data = $this->getCachedStatisticalData($user);


        $data = [
            'labels' => $statistical_data['labels'],
            'chart-click-count-comparison' => [
                'data' => $statistical_data['click_count_data'],
                'title' => 'Click count comparison',
            ],
            'chart-conversion-count-comparison' => [
                'data' => $statistical_data['conversions_count_data'],
                'title' => 'Conversion count comparison',
            ],
            'chart-conversion-ratio-comparison' => [
                'data' => $statistical_data['conversion_ratio_data'],
                'title' => 'Conversion ratio comparison',
            ],
        ];

        // Provide the User model to the view
        return view('affiliate.affiliate-user-graphical-statistics', [
            'user' => $user,
            'statistics' => $data,
        ]);
    }

    /**
     * Display tabular statistics view.
     */
    public function tabular(User $user): View
    {
        if (! $user->is_affiliate) {
            abort(404);
        }

        $statistical_data = $this->getCachedStatisticalData($user);

        // Provide the User model to the view
        return view('affiliate.affiliate-user-tabular-statistics', [
            'user' => $user,
            'statistics' => $statistical_data,
        ]);
    }

    /**
     * @param User $user
     * @return array
     */
    protected function getCachedStatisticalData(User $user): array
    {
        // Cache the statistical data for 5 minutes, no need to get it all the time as it is not rocket telemetry.
        return Cache::remember('afiiliate-statistics-' . md5($user->id), now()->addMinutes(5), function () use ($user) {
            return DenormalizedAffiliateCodeClick::getStatisticalDataByUser($user);
        });

    }
}
