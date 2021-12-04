@extends('vendor.app')

@section('title',$title)

@section('content')

    <section class="order-page contact-section">
        <div class="container">
            <h1>{{$title}}</h1>
            <div class="row">
                <div class="order-details col-md-6">

                    <h3>Order details:</h3>
                    <ul>
                        @foreach ($details as $label => $val)
                            <li><b>{{$label}}:</b> {{$val}} </li>
                        @endforeach
                    </ul>
                </div>
                <div class="order-products col-md-6">
                    <h3>Order products:</h3>
                    @if ($order->products != false)
                        <table class="table order-products">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">QTY</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td><img src="{{$product->image->img}}" alt="product"></td>
                                        <td><a href="{{ route('product', $product->slug ) }}">{{$product->name}}</a></td>
                                        <td>{{$product->pivot->color}}</td>
                                        <td>{{$product->pivot->size}}</td>
                                        <td>{{$product->formatted_price}}</td>
                                        <td>{{$product->pivot->qty}}</td>
                                        <td>{{$product->formatted_subtotal}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h2>No products!</h2>
                    @endif
                </div>

            </div>
        </div>
    </section>

@include('parts.product.recently-viewed')

@endsection
