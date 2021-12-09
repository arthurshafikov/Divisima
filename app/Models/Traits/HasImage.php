<?php

namespace App\Models\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasImage
{
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function getImageString(): string
    {
        return $this->image ? $this->image->img : '';
    }

    public function getImageTagAttribute(): string
    {
        return '<img src="' . $this->getImageString() . '">';
    }
}
