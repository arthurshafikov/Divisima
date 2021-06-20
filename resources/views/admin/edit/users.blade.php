@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('users.update',$user->id) }}">
        @csrf
        {{ method_field('PATCH') }}

        <x-input name="name" :value="$user->name" type="text" pholder="Username" label="Username" />

        <x-input name="email" :value="$user->email" type="email" pholder="Email" label="User Email" />

        <x-input name="password" :value="''" type="password" pholder="Password" label="New User Password" />

        <x-input name="verify" :value="$user->isVerified()" type="checkbox" label="Verify email?" />
 
        @include('admin.parts.form.button')
    </form>
@endsection
