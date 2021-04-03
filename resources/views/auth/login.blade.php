@extends('vendor.app')

@section('title',$title)

@section('content')
    @include('parts.page-info')

    <div class="auth-wrapper">
        <div class="container">
            <div class="auth">
                <form method="POST" action="{{ route('login',['redirect_to' => request()->get('redirect_to')] ) }}">
                    @csrf
                    <div class="form-group">
                        <label for="logininput">Your E-mail / Login</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                        @error('email')
                            @include('errors.field-error')
                        @enderror
                        @error('name')
                            @include('errors.field-error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password1">Your Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            @include('errors.field-error')
                        @enderror
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    
                </form>
                <a href="{{ route('login') }}" class="">Already have an account?</a>
            </div>
        </div>
    </div>

	@include ('parts.product.recently-viewed')
@endsection