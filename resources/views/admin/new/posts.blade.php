@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <x-input name="title" :value="old('title')" placeholder="Title of the post" label="Title" />

        <x-image :value="old('image_id')" :src="App\Models\Image::find(old('image_id'))?->src"/>

        <x-textarea id="content" label="Content" placeholder="Content of the post" :value="old('content')" />

        @include('admin.parts.form.button')
    </form>
@endsection
