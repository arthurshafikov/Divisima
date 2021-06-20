<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Models\Traits\HasImage;
use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function category()
    {
        return $this->belongsToMany('App\Models\Category')->using('App\Models\Pivots\CategoryProduct');
    }

    public function attributes()
    {
        return $this->belongsToMany(
            Attributes\AttributeVariation::class,
            'product_variations',
            null,
            'variation_id'
        );
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('qty', 'size', 'color', 'subtotal');
    }

    public function getStockStatusAttribute()
    {
        return snakeCaseToNormal($this->stock);
    }

    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->pivot->subtotal, 2);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
