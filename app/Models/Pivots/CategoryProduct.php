<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryProduct extends Pivot
{
    //
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }
    public function product()
    {
        return $this->belongsTo('\App\Models\Product');
    }
}
