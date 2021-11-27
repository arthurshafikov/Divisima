<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'text',
        'rating',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('j F Y');
    }
}
