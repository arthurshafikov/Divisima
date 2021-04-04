@if ($reviews->count() > 0)
    @foreach ($reviews as $review)
        @include('parts.reviews.review')
    @endforeach
    <a href="{{ route('getReviews',$id) }}" class="reviews-load load-more">Load more</a>
@endif