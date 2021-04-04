<!DOCTYPE html>
<html lang="en">
@include('admin.header.head')


<body class="sb-nav-fixed">
    @include('admin.header.header')

    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        @foreach ($admin_menu as $header => $array)
                            <div class="sb-sidenav-menu-heading">{{$header}}</div>

                                @foreach ($array as $el)
                                    @if (!is_array($el['link']))
                                        <a class="nav-link" href="{{ route($el['link']) }}">
                                            <div class="sb-nav-link-icon"><i class="fas {{$el['icon'] ?? ''}}"></i></div>
                                            {{$el['text']}}
                                        </a>
                                    @else
                                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$el['text']}}" aria-expanded="false" aria-controls="{{$el['text']}}">
                                            <div class="sb-nav-link-icon"><i class="fas {{$el['icon'] ?? ''}}"></i></div>
                                            {{ $el['text'] }}
                                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                        </a>
                                        <div class="collapse" id="{{$el['text']}}" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                            <nav class="sb-sidenav-menu-nested nav">
                                                    @foreach ($el['link'] as $route => $title)
                                                        <a class="nav-link" href="{{ route($route)}}">{{$title}}</a>
                                                    @endforeach
                                            </nav>
                                        </div>
                                    @endif
                                @endforeach
                        @endforeach
                        

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: {{ Auth::user()?->name }}</div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website {{ date('Y') }}</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    @include('admin.footer.footer')
    
    @include('admin.parts.media')

</body>

</html>