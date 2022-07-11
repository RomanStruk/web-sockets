<?php

namespace Database\Seeders;

use App\Models\AuctionTime;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        AuctionTime::factory()->count(5)->create();
    }
}
