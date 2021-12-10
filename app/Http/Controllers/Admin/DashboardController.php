<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'users' => User::orderBy('id', 'desc')->take(10)->get(),
        ]);
    }

    public function chart(): View
    {
        return view('admin.chart');
    }
}
