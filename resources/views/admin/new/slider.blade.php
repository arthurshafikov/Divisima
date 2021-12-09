@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('slider.store') }}">
        @csrf

        <x-input name="title" :value="old('title')" placeholder="Title of the slide" label="Title" />

        <x-image :value="old('image_id')" :src="App\Models\Image::find(old('image_id'))?->src"/>

        <x-textarea label="Content" placeholder="Content of the slide" :value="old('content')" />

        @include('admin.parts.form.button')
    </form>
@endsection
