<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('id', 'desc')->take(10)->get();

        return view('admin.dashboard', [
            'users' => $users,
        ]);
    }

    public function chart(): View
    {
        return view('admin.chart');
    }
}
