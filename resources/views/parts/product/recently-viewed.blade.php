@if(count($viewed) > 0)
<!-- Related product section -->
<section class="related-product-section">
    <div class="container">
        <div class="section-title text-uppercase">
            <h2>Recently Viewed</h2>
        </div>
        <div class="product-slider owl-carousel">
            @foreach($viewed as $product)
                @include ('parts.product.product')
            @endforeach
        </div>
    </div>
</section>
<!-- Related product section end -->
@endif