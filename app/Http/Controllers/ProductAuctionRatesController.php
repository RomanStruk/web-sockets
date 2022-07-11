<?php

namespace App\Http\Controllers;

use App\Events\AuctionLeftTimeEvent;
use App\Events\AuctionRateUpEvent;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAuctionRatesController extends Controller
{
    public function store(Product $product, Request $request)
    {
        $auctionRate = $product->auctionRates()->create([
            'price' => $request->price,
            'user_id' => auth()->user()->id,
        ]);
        $auctionRate->load('user');

        broadcast(new AuctionRateUpEvent(auth()->user(), $auctionRate, $product))->toOthers();

        if ($product->auctionTime->left_time < now()->addMinutes(5)){
            $product->auctionTime()->update(['left_time' => $product->auctionTime->left_time->addMinutes(5)]);
        }

        broadcast(new AuctionLeftTimeEvent(auth()->user(), $product->auctionTime, $product));

        return $auctionRate;
    }
}
