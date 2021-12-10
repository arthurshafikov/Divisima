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
        $this->essense = 'users';
        $this->td = ['id','name','email','email_verified_at','created_at'];
        $this->th = ['ID','Name','Email','Verified at','Registred At'];
        $this->oneText = 'User';
    }

    public function edit($id): View
    {
        return view('admin.edit.' . $this->essense, [
            'user' => User::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        app(UserService::class, ['user' => User::findOrFail($id)])->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->oneText]));
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'verify' => 'nullable|numeric',
        ]);
    }
}
