@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('attributes.store') }}">
        @csrf

        <x-input name="name" :value="old('name')" placeholder="Name of the attribute" label="Name" />
            
        <x-multiple-items name="variation" pholder="Name of the variation" :post="null" iterable="null" />
            
        @include('admin.parts.form.button')
    </form>
@endsection
