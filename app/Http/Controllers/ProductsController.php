<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->paginate();

        return view('product.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('auctionRates.user');

        return view('product.show', compact('product'));
    }
}
