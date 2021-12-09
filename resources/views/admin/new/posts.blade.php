@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <x-input name="name" :value="old('name')" placeholder="Name of the post" label="Name" />

        <x-image :value="old('image_id')" :src="App\Models\Image::find(old('image_id'))?->src"/>

        <x-textarea id="content" label="Content" placeholder="Content of the post" :value="old('content')" />

        @include('admin.parts.form.button')
    </form>
@endsection
