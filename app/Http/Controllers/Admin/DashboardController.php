<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->take(10)->get();
        return view('admin.dashboard',[
            'users' => $users,
        ]);
    }

    public function chart()
    {
        return view('admin.chart');
    }
}
