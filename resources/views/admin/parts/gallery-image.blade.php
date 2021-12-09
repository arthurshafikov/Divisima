<div class="gallery-img @if(isset($post) && $img->id === optional($post->image)->id) {{ 'active' }} @endif" data-id="{{ $img->id }}">
    <img src="{{ $img->img }}" alt="">
</div>
