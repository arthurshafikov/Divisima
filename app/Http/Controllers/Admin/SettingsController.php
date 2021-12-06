<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('admin.settings', [
            'settings' => setting()->all(),
        ]);
    }

    public function save(Request $request)
    {
        $options = $request->except('_token');
        foreach ($options as $key => $value) {
            setting([$key => $value]);
        }
        setting()->save();

        return redirect()->back()->with('message', __('admin/crud.saved', ['name' => 'Settings']));
    }
}
