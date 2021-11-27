<?php

namespace App\Models;

use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SluggableTrait;
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'parent_id',
        'name',
        'slug',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Product')->using('App\Models\Pivots\CategoryProduct');
    }

    public function childs(): HasMany
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id') ;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getNameAttribute($value): string
    {
        return ucwords($value);
    }
}
