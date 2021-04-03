<?php

namespace App\Models\Attributes;

use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class AttributeVariation extends Model
{
    
    use SluggableTrait;
    
    public $timestamps = false;

    protected $fillable = ['name','attribute_id','active']; 
    protected $appends = ['active']; // for shop filter (checked)

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product','product_variations','variation_id',null);
    }
}
