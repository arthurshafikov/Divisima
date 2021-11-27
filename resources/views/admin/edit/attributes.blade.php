@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('attributes.update',$post->id) }}">
        @csrf
        @method('PATCH')

        <x-input name="name" :value="$post->name" pholder="Name of the attribute" label="Name" />

        <x-multiple-items name="variation" pholder="Name of the variation" :post="$post" iterable="variations" />

        @include('admin.parts.form.button')
    </form>
@endsection
