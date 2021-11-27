<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Pivot
{
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Category');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo('\App\Models\Product');
    }
}
