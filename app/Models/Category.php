<?php

namespace App\Models;

use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SluggableTrait,HasFactory;
    
    public $timestamps = false;

    public $fillable = ['parent_id','name','slug'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->using('App\Models\Pivots\CategoryProduct');
    }

    public function childs() 
    {
        return $this->hasMany('App\Models\Category','parent_id','id') ;
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

}
