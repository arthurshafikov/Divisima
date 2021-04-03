<?php

namespace App\Models;

use App\Http\Controllers\Admin\OptionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','status','address','zip','phone','country','delivery','subtotal','discount','total','additional'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty','size','color','subtotal');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute()
    {
        return getOption('order_status',$this->status);
    }

    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total,2);
    }

    public function getSubtotalAttribute($value)
    {
        return '$' . number_format($value,2);
    }

    public function getDiscountAttribute($value)
    {
        return '$' . number_format($value,2);
    }
}
