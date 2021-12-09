<!-- Footer section -->
<section class="footer-section">
    <div class="container">
        <div class="footer-logo text-center">
            <a href="{{ route('home') }}"><img src="/img/logo-light.png" alt=""></a>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>About</h2>
                    <p>{{ setting('footer_about') }}</p>
                    <img src="/img/cards.png" alt="">
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>Questions</h2>
                    <ul>
                        @if ($menu !== null)
                            @foreach ($menu->items as $item)
                                <li><a href="{{ $item->path }}">{{ $item->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>Blog</h2>
                    <div class="fw-latest-post-widget">
                        @foreach ($posts as $post)
                            <div class="lp-item">
                                <div class="lp-thumb set-bg" data-setbg="{{ $post->getImageString() }}"></div>
                                <div class="lp-content">
                                    <h6>{{$post->name}}</h6>
                                    <span>{{$post->created_at}}</span>
                                    <a href="{{ route('post',$post->slug) }}" class="readmore">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget contact-widget">
                    <h2>Questions</h2>
                    <div class="con-info">
                        <span>C.</span>
                        <p>{{ setting('company_name') }}</p>
                    </div>
                    <div class="con-info">
                        <span>B.</span>
                        <p>{{ setting('company_address') }}</p>
                    </div>
                    <div class="con-info">
                        <span>T.</span>
                        <p>{{ setting('company_phone') }}</p>
                    </div>
                    <div class="con-info">
                        <span>E.</span>
                        <p>{{ setting('company_email') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social-links-warp">
        <div class="container">
            <div class="social-links">
                <a href="{{ setting('instagram_link') }}" class="instagram"><i class="fa fa-instagram"></i><span>instagram</span></a>
                <a href="{{ setting('google_link') }}" class="google-plus"><i class="fa fa-google-plus"></i><span>g+plus</span></a>
                <a href="{{ setting('pinterest_link') }}" class="pinterest"><i class="fa fa-pinterest"></i><span>pinterest</span></a>
                <a href="{{ setting('facebook_link') }}" class="facebook"><i class="fa fa-facebook"></i><span>facebook</span></a>
                <a href="{{ setting('twitter_link') }}" class="twitter"><i class="fa fa-twitter"></i><span>twitter</span></a>
                <a href="{{ setting('youtube_link') }}" class="youtube"><i class="fa fa-youtube"></i><span>youtube</span></a>
                <a href="{{ setting('tumblr_link') }}" class="tumblr"><i class="fa fa-tumblr-square"></i><span>tumblr</span></a>
            </div>

            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <p class="text-white text-center mt-5">Copyright &copy;<script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

        </div>
    </div>
</section>

<script src="{{ asset('/assets/all.js') }}"></script>
<script src="{{ asset('/assets/app.js') }}"></script>
