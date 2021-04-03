<!-- Hero section -->
<section class="hero-section">
    <div class="hero-slider owl-carousel">
        @foreach($slider as $slide)
        <div class="hs-item set-bg" data-setbg="{{ $slide->img() ?? '' }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 text-white">
                        <h2>{{ $slide->title }}</h2>
                        <p>{{ $slide->content }}</p>
                        <!-- <a href="#" class="site-btn sb-line">DISCOVER</a> -->
                        <!-- <a href="#" class="site-btn sb-white">ADD TO CART</a> -->
                        <a href="{{ route('shop') }}" class="site-btn sb-white">GO TO SHOP</a>
                    </div>
                </div>
                <!-- <div class="offer-card text-white">
                    <span>from</span>
                    <h2>$29</h2>
                    <p>SHOP NOW</p>
                </div> -->
            </div>
        </div>
        @endforeach
    </div>
    <div class="container">
        <div class="slide-num-holder" id="snh-1"></div>
    </div>
</section>
<!-- Hero section end -->