<?php

namespace App\Models;

use App\Models\Traits\HasImage;
use App\Models\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;
    use SluggableTrait;
    use HasImage;

    protected $fillable = [
        'name',
        'content',
        'image_id',
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('j F Y');
    }
}
