@can(\App\Models\Permission::ADMIN_PANEL)
    <div class="admin-bar-wrapper">
        <div class="admin-bar">
            <a href="{{ route('admin') }}">Dashboard</a>
        </div>
    </div>
@endauth
<!-- Header section -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 text-center text-lg-left">
                    <!-- logo -->
                    <a href="/" class="site-logo">
                        <img src="/img/logo.png" alt="">
                    </a>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <form class="header-search-form" action="{{ route('shop') }}">
                        <input type="text" name="search" placeholder="Search on divisima ....">
                        <button><i class="flaticon-search"></i></button>
                    </form>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="user-panel">
                        <div class="up-item">
                            @auth
                                <i class="flaticon-profile"></i>
                                <a href="{{ route('account') }}">My account</a>
                                <form action="{{ route('logout') }}" method="POST" class="logoutForm" >
                                    @csrf
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    <button type="submit" dusk="logout-button">Log out</button>
                                </form>
                            @endauth

                            @guest
                                <a href="{{ route('login') }}">Sign In</a> or <a href="{{ route('register') }}">Create Account</a>
                            @endguest
                            <div class="shopping-card">
                                <i class="flaticon-bag"></i>
                                <span id="shopping-cart-count">{{ $cartCount }}</span>
                            </div>
                            <a href="{{ route('cart') }}">Shopping Cart</a>


                            <a href="{{ route('wishlist') }}"><i class="flaticon-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <!-- menu -->
            <ul class="main-menu">
                @if ($menu !== null)
                    @foreach ($menu->items as $item)
                        <li><a href="{{ $item->path }}">{{ $item->name }}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>
</header>
<!-- Header section end -->
