<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SettingsService;
use Illuminate\Http\RedirectResponse;
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

    public function save(Request $request): RedirectResponse
    {
        app(SettingsService::class)->save($request->except('_token'));

        return redirect()->back()->with('message', __('admin/crud.saved', ['name' => 'Settings']));
    }
}
