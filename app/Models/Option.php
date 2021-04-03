<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;

    protected $fillable = ['key','value'];

    public function name()
    {
        return ucwords(str_replace('_',' ',$this->key));
    }

    public function setValueAttribute($val)
    {
        if(is_array($val)){
            $val = serialize($val);
        }
        $this->attributes['value'] = $val;
    }

    public function getValueAttribute($val)
    {
        if(preg_match('/^a:\d+:{/',$val)){
            // this is serialized array
            $val = unserialize($val);
        }
        return $val;
    }
}
