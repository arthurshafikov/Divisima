<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Product;

class ProductViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->productId = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
