<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends CRUDController
{
    public function __construct()
    {
        $this->model = User::class;
        $this->routePrefix = 'users';
        $this->tableData = ['id','name','email','email_verified_at','created_at'];
        $this->tableHeaders = ['ID','Name','Email','Verified at','Registred At'];
        $this->title = 'User';
    }

    public function edit(int $id): View
    {
        return view('admin.edit.' . $this->routePrefix, [
            'user' => User::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        app(UserService::class, ['user' => User::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->title]));
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'verify' => 'nullable|numeric',
            'password' => 'nullable|string',
        ]);
    }
}
