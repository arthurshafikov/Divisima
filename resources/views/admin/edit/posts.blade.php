@extends('admin.vendor.crud')

@section('form')
<a href="{{ route('post',$post->slug) }}" target="_blank">View post</a>
    <form method="POST" action="{{ route('posts.update',$post->id) }}">
        @csrf
        @method('PATCH')

        <x-input name="name" :value="$post->name" pholder="Name of the post" label="Name" />

        <x-image :value="$post->image->id" :src="$post->getImageString()"/>

        <x-textarea id="content" label="Content" pholder="Content of the post" :value="$post->content" />

        @include('admin.parts.form.button')
    </form>
@endsection
