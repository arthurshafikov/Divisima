<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Models\Attributes\AttributeVariation;
use App\Models\Attributes\AttributeVariationProduct;
use App\Models\Pivot\OrderProduct;
use App\Models\Traits\HasImage;
use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use SluggableTrait;
    use HasFactory;
    use HasImage;

    public const PRODUCT_IN_STOCK_STATUS = 'in_stock';
    public const PRODUCT_PRE_ORDER_STATUS = 'pre_order';
    public const PRODUCT_OUT_OF_STOCK_STATUS = 'out_of_stock';
    public const PRODUCT_STOCK_STATUSES = [
        self::PRODUCT_IN_STOCK_STATUS,
        self::PRODUCT_PRE_ORDER_STATUS,
        self::PRODUCT_OUT_OF_STOCK_STATUS,
    ];

    public $timestamps = false;
    protected $fillable = [
        'name',
        'img',
        'price',
        'stock',
        'details',
        'description',
    ];

    protected $attributes = [
        'total_sales' => 0,
    ];

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(AttributeVariation::class)->using(AttributeVariationProduct::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->using(OrderProduct::class);
    }

    public function getStockStatusAttribute(): string
    {
        return snakeCaseToNormal($this->stock);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '$' . number_format($this->pivot->subtotal, 2);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
