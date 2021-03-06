<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

    public $fillable = [
        'promocode',
        'discount',
        'expired_at',
    ];

    protected $dates = [
        'expired_at',
    ];

    public function getPureDateAttribute(): string
    {
        return trim(str_replace('00:00:00', '', $this->expired_at));
    }
}
