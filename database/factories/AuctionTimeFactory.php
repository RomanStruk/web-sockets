<?php

namespace Database\Factories;

use App\Models\AuctionTime;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuctionTimeFactory extends Factory
{
    protected $model = AuctionTime::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'left_time' => now()->addHours(2),
        ];
    }
}
