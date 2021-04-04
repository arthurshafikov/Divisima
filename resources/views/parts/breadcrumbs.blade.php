<div class="site-pagination">
    @foreach ($breadcrumbs as $link => $name)
        <a href="{{$link}}">{{$name}}</a> /
    @endforeach
</div>