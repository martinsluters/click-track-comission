<?php

namespace Database\Factories\Affiliate;

use App\Models\Affiliate\AffiliateCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Affiliate\AffiliateCodeClickEvent>
 */
class AffiliateCodeClickEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'affiliate_code_id' => AffiliateCode::factory(),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
