@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('categories.update',$post->id) }}">
        @csrf
        {{ method_field('PATCH') }}
        
        <x-input name="name" :value="$post->name" pholder="Name of the category" label="Name" />

        <x-select name="parent_id" :array="\App\Models\Category::all()" :compared="$post->parent_id" default="No parent"/>

        @include('admin.parts.form.button')
    </form>
@endsection