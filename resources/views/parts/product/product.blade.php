<div class="product-item" data-product-id="{{ $product->id }}">
    <div class="pi-pic">
        <img src="{{ $product->getImageString() }}" alt="">
        <div class="pi-links">
            <a href="{{ route('loadAttributes',$product->id) }}" class="add-cart-open-modal"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
            <a href="{{ route('addToWishlist',$product->id) }}" class="wishlist-btn"><i class="flaticon-heart"></i></a>
        </div>
    </div>
    <div class="pi-text">
        <h6>{{ $product->formatted_price }}</h6>
        <p><a href="{{ route('product',$product->slug) }}">{{ $product->name }}</a></p>
    </div>
</div>
