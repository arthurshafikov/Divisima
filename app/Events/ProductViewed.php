<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductViewed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $productId;

    public function __construct($id)
    {
        $this->productId = $id;
    }
}
