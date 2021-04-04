<ol class="breadcrumb mb-4">
    @foreach ($breadcrumbs as $link => $name)
        @if ($loop->last)
            <li class="breadcrumb-item active">{{$name}}</li>
            @continue
        @endif
        <li class="breadcrumb-item"><a href="{{ $link }}">{{$name}}</a></li>
    @endforeach
</ol>