<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['auctionRates', 'auctionTime'];

    public function auctionRates()
    {
        return $this->hasMany(AuctionRate::class)->latest()->limit(4);
    }

    public function auctionTime()
    {
        return $this->hasOne(AuctionTime::class)->latest()->withDefault(['left_time' => 0]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
