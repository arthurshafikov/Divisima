<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\View\View;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public string $usernameFieldType;

    protected string $redirectTo;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if (!empty($redirect = request()->get('redirect_to'))) {
            $this->redirectTo = $redirect;
        } else {
            $this->redirectTo = route('home');
        }

        $this->usernameFieldType = $this->findUsername();
    }

    public function findUsername(): string
    {
        $login = request()->input('username');
        $usernameFieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        request()->merge([$usernameFieldType => $login]);

        return $usernameFieldType;
    }

    public function username()
    {
        return $this->usernameFieldType;
    }

    public function showLoginForm(): View
    {
        return view('auth.login')->with([
            'title' => __('auth.title'),
        ]);
    }
}
