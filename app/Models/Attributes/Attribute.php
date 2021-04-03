<?php

namespace App\Models\Attributes;

use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use SluggableTrait;
    
    public $timestamps = false;
    protected $fillable = ['name'];
    
    public function variations()
    {
        return $this->hasMany(AttributeVariation::class);
    }

    // public function getNameAttribute($val)
    // {
    //     return ucfirst($val);
    // }
}
