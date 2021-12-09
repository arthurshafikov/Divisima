@extends('vendor.app')

@section('title', $title)

@section('content')
	@include('parts.page-info')

    <div class="blog-wrapper">
        <div class="container">
            <div class="blog">
                @foreach($posts as $post)
                    <div class="blog-single">
                        <div class="single-image">
                            <a href="{{ route('post',$post->slug)}}">
                                <figure>
                                    <img src="{{ $post->getImageString() }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="single-content">
                            <div class="single-title">
                                <a href="{{ route('post',$post->slug)}}">{{$post->name}}</a>
                            </div>
                            <div class="content">
                                <p>{{ substr($post->content,0,150) }}</p>
                                <small>{{ $post->created_at }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $posts->links() }}
            </div>
        </div>
    </div>

	@include ('parts.product.recently-viewed')
@endsection
