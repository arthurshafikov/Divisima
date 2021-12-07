<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    public $timestamps = false;

    protected $casts = [
        'attributes' => 'json',
    ];
}
