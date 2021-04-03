@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <x-input name="name" :value="old('name')" placeholder="Name of the category" label="Name" />

        <x-select name="parent_id" :array="\App\Models\Category::all()" :compared="old('parent_id')" default="No parent"/>
        
        @include('admin.parts.form.button')
    </form>
@endsection
