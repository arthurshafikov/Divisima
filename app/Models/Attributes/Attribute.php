<?php

namespace App\Models\Attributes;

use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use SluggableTrait;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function variations(): HasMany
    {
        return $this->hasMany(AttributeVariation::class);
    }
}
