<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected static $options = [];

    public function index()
    {
        $options = Option::all();
        return view('admin.options', [
            'options' => $options,
        ]);
    }

    public function save(Request $request)
    {
        $options = $request->except('_token');
        foreach($options as $key => $value){
            Option::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('message','Options has been saved successfully!');
    }

    public static function getOption(string $option,$val = false)
    {
        if(!array_key_exists($option,static::$options)){
            static::$options[$option] = Option::where('key',$option)?->first()?->value;
        }
        $option = static::$options[$option];
        
        if($val === false){
            return $option;
        }
        if(array_key_exists($val,$option) && is_array($option)){
            return $option[$val];
        }
        return 'error';
    }

}
