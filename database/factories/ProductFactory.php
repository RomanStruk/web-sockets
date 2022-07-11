<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'user_id' => User::first()->id,
            'title' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 999)
        ];
    }
}
