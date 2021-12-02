<?php

namespace App\Models\Attributes;

use App\Models\Product;
use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeVariation extends Model
{
    use SluggableTrait;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'attribute_id',
        'active',
    ];

    protected $appends = [
        'active',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_variations', 'variation_id');
    }
}
