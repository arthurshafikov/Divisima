<?php

namespace App\Models\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasImage
{
    public function image(): HasOne
    {
        return $this->hasOne(Image::class, 'id', 'img');
    }

    public function img(): ?string
    {
        if (!is_object($this->image)) {
            return '';
        }
        return $this->image->img;
    }

    public function getImageTagAttribute(): string
    {
        return '<img src="' . $this->img() . '">';
    }
}
