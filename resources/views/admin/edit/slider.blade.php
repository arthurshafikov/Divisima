@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('slider.update',$post->id) }}">
        @csrf
        @method('PATCH')

        <x-input name="title" :value="$post->title" pholder="Title of the slide" label="Title" />

        <x-image :value="$post->img" :src="$post->img()"/>

        <x-textarea label="Content" placeholder="Content of the slide" :value="$post->content" />

        @include('admin.parts.form.button')
    </form>
@endsection
