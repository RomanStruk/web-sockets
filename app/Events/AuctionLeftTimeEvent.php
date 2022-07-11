<?php

namespace App\Events;

use App\Models\AuctionRate;
use App\Models\AuctionTime;
use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionLeftTimeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    /**
     * @var AuctionTime
     */
    public $auctionTime;
    /**
     * @var Product
     */
    public $product;

    public function __construct($user, AuctionTime $auctionTime, Product $product)
    {
        $this->user = $user;
        $this->auctionTime = $auctionTime;
        $this->product = $product;
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('auction-' . $this->product->id);
    }
}
