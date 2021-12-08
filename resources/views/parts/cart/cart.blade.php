@include('parts.flashes')
<div class="row">
    @if (count($items) < 1)
        Your cart is empty!
    @else
    <div class="col-lg-8">
        <div class="cart-table">

            <div class="preloader">
                <div class="loader"></div>
            </div>
            <h3>Your Cart</h3>

            <div class="cart-table-warp">
                <table>
                    <thead>
                        <tr>
                            <th class="product-th">Product</th>
                            <th class="quy-th">Quantity</th>
                            <th class="size-th">Size</th>
                            <th class="color-th">Color</th>
                            <th class="total-th">Price</th>
                            <th class="total-th">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="cart-product" data-id="{{ $item->id }}" >
                                <td class="product-col" data-price="{{ $item->price }}">
                                    <img src="{{ $item->img() }}" alt="">
                                    <div class="pc-title">
                                        <h4><a href="{{ route('product',$item->slug)}}">{{ $item->name }}</a></h4>
                                        <p>{{ $item->formatted_price }}</p>
                                    </div>
                                </td>
                                <td class="quy-col">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="{{ $cart[$item->id]['qty'] }}">
                                        </div>
                                    </div>
                                </td>
                                <td class="size-col">
                                    {{ mb_strtoupper(data_get($item->attributes, 'size')) }}
                                </td>
                                <td class="color-col">
                                    <span class="{{ data_get($item->attributes, 'color') }}-color"></span>
                                </td>
                                <td class="total-col">
                                    <h4>${{ $item->total }}</h4>
                                </td>
                                <td class="remove-col">
                                    <form action="{{ route('removeFromCart', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-from-cart" aria-label="Remove">
                                            &times;
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-cost">
                <table class="table table-sm">
                    <tbody>
                        @if ($promocode)
                            <tr>
                                <td><h6>Promocode applied</h6></td>
                                <td><h6><span>{{ $promocode }}%</span></h6></td>
                                <td><form action="{{ route('removePromocode') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary">Delete</button>

                                    </form></td>
                            </tr>
                        @endif

                        <tr>
                            <td><h6>Total</h6></td>
                            <td><h6><span>${{ $total }}</span></h6></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-lg-4 card-right">
        <form class="promo-code-form" method="POST">
            @csrf
            <input type="text" name="promocode" placeholder="Enter promo code">
            <button>Submit</button>
        </form>
        <a href="{{ route('updateCart') }}" class="cart-update">Update the cart</a>
        <a href="{{ route('checkout') }}" class="site-btn">Proceed to checkout</a>
        <a href="{{ route('shop') }}" class="site-btn sb-dark">Continue shopping</a>
        <a href="{{ route('resetCart') }}" class="btn btn-danger" onclick="if(!confirm('Confirm cart resetting?')){return false;}">Reset Cart</a>
    </div>
    @endif
</div>
