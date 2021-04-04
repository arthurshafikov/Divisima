<?php
namespace App\Models\Traits;

use App\Models\Image;

trait HasImage 
{
    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'img'); 
    }

    public function img()
    {
        if (!is_object($this->image))
            return '';
        return $this->image->img;
    }

    public function getImageTagAttribute()
    {
        return '<img src="'.$this->img().'">';
    }
}