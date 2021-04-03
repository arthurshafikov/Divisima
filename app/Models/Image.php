<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['img'];

    public function getImgAttribute($value)
    {
        return '/storage/' . $value;
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }
}
