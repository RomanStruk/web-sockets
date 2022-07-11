<?php

namespace App\Events;

use App\Models\AuctionRate;
use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionRateUpEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    /**
     * @var AuctionRate
     */
    public $auctionRate;
    /**
     * @var mixed
     */
    protected $product;

    public function __construct($user, AuctionRate $auctionRate, Product $product)
    {
        $this->user = $user;
        $this->auctionRate = $auctionRate;
        $this->product = $product;
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('auction-' . $this->product->id);
    }
}
