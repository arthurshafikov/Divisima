<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
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
        foreach ($options as $key => $value) {
            Option::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('message', 'Options has been saved successfully!');
    }
}
