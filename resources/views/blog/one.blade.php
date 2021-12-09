@extends('vendor.app')

@section('title', $title)

@section('content')
	@include('parts.page-info')

    <div class="wrapper">
        <div class="container">
            <div class="blog-post">
                <div class="blog-image">
                    <figure>
                        <img src="{{$post->getImageString()}}" alt="">
                    </figure>
                </div>
                <div class="blog-content">
                    <p>{!! $post->content !!}</p>
                </div>
                <small>{{$post->created_at}}</small>
            </div>
        </div>
    </div>

	@include('parts.banner')

    @include('parts.product.top-selling')
@endsection
