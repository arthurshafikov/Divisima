<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OptionController extends Controller
{
    public function index(): View
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

        return redirect()->back()->with('message', __('admin/crud.saved', ['name' => 'Options']));
    }
}
