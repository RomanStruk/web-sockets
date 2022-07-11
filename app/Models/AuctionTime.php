<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionTime extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'left_time' => 'datetime'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
