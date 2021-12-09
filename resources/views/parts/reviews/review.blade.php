<div class="review" data-id="{{ $review->id }}">
    <div class="review-author">
        <img src="{{ $review->user->profile->avatar->src ?? $defaultAvatar}}" alt="avatar">
        <p>{{ $review->user->name }}</p>
    </div>
    <div class="rating-result">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i> $review->rating)
                <span><i class="fa fa-star-o"></i></span>
            @else
                <span class="active"><i class="fa fa-star-o"></i></span>
            @endif
        @endfor
    </div>

    <div class="review-content">
        {{ $review->text }}
    </div>
    <small>
        {{ $review->created_at }}
    </small>
    @if ($review->user->id === Auth::id())
        <small>
            <form action="{{ route('delete-review',$review->id)}}" class="delete-review-form">
                @csrf
                <button type="submit" href="#" class="btn btn-danger delete-review-btn"> Delete review </button>
            </form>
        </small>
    @endif
</div>
