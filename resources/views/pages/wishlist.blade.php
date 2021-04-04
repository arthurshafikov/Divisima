@extends('vendor.app')

@section('title',$title)

@section('content')

<section class="contact-section wishlist">
    <div class="container">
        <div class="row">
            <div>
                <h1>{{$title}}</h1>
            </div>
        </div>

        <div class="row ">
            @if ($products->count())
                <table class="table order-products">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Add To Cart</th>
                            <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td><img src="{{$product->image->img}}" alt="product"></td>
                                <td><a href="{{ route('product', $product->slug ) }}">{{$product->name}}</a></td>
                                <td>{{$product->formatted_price}}</td>
                                <td><a href="{{ route('addToCart',$product->id) }}" class="btn btn-primary add-cart"><i class="flaticon-bag"></i><span>ADD TO CART</span></a></td>
                                <td><a href="{{ route('removeFromWishlist',$product->id) }}" class="wishlist-remove">&times;</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info" role="alert">
                    You have not added any products to your wishlist yet.
                </div>
            @endif
        </div>
    </div>
</section>


@include('parts.product.recently-viewed')


@endsection