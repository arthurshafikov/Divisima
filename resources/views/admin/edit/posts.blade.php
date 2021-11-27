@extends('admin.vendor.crud')

@section('form')
<a href="{{ route('post',$post->slug) }}" target="_blank">View post</a>
    <form method="POST" action="{{ route('posts.update',$post->id) }}">
        @csrf
        @method('PATCH')

        <x-input name="title" :value="$post->title" pholder="Title of the post" label="Title" />

        <x-image :value="$post->img" :src="$post->img()"/>

        <x-textarea id="content" label="Content" pholder="Content of the post" :value="$post->content" />

        @include('admin.parts.form.button')
    </form>
@endsection
