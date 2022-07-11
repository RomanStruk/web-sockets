<?php

use App\Http\Controllers\ProductAuctionRatesController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/products/', [ProductsController::class, 'index'])
        ->name('products.index');
    Route::get('/products/{product}/', [ProductsController::class, 'show'])
        ->name('products.show');
    Route::post('/products/{product}/up', [ProductAuctionRatesController::class, 'store'])
        ->name('products.action-rate.up');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::view('/', 'welcome')->name('home');

Route::get('/chat', [ChatsController::class, 'index'])->middleware(['auth']);
Route::get('/messages', [ChatsController::class, 'fetchMessages']);
Route::post('/messages', [ChatsController::class, 'sendMessage']);

require __DIR__.'/auth.php';
