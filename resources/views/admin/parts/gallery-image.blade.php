<div class="gallery-img @if(isset($post) && $img->id === $post->img) {{ 'active' }} @endif" data-id="{{ $img->id }}">
    <img src="{{ $img->img }}" alt="">
</div>