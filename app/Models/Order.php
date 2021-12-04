<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    public const ORDER_IN_PROGRESS_STATUS = 'in_progress';
    public const ORDER_ON_HOLD_STATUS = 'on_hold';
    public const ORDER_COMPLETED_STATUS = 'completed';
    public const ORDER_DECLINED_STATUS = 'declined';
    public const ORDER_STATUSES = [
        self::ORDER_IN_PROGRESS_STATUS,
        self::ORDER_ON_HOLD_STATUS,
        self::ORDER_COMPLETED_STATUS,
        self::ORDER_DECLINED_STATUS,
    ];

    public const ORDER_COURIER_DELIVERY_METHOD = 'courier';
    public const ORDER_POST_DELIVERY_METHOD = 'post';
    public const ORDER_POST_EXPRESS_DELIVERY_METHOD = 'post_express';
    public const ORDER_DELIVERY_METHODS = [
        self::ORDER_COURIER_DELIVERY_METHOD,
        self::ORDER_POST_DELIVERY_METHOD,
        self::ORDER_POST_EXPRESS_DELIVERY_METHOD,
    ];

    protected $fillable = [
        'user_id',
        'status',
        'address',
        'zip',
        'phone',
        'country',
        'delivery',
        'subtotal',
        'discount',
        'total',
        'additional',
    ];

    protected $attributes = [
        'status' => self::ORDER_IN_PROGRESS_STATUS,
        'subtotal' => 0,
        'total' => 0,
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('qty', 'size', 'color', 'subtotal');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute(): string
    {
        return snakeCaseToNormal($this->status);
    }

    public function getDeliveryTextAttribute(): string
    {
        return snakeCaseToNormal($this->delivery) . ' Delivery';
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total, 2);
    }

    public function getSubtotalAttribute($value): string
    {
        return '$' . number_format($value, 2);
    }

    public function getDiscountAttribute($value): string
    {
        return '$' . number_format($value, 2);
    }
}
