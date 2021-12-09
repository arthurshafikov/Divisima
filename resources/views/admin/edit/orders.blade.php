@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('orders.update',$post->id) }}">
        @csrf
        @method('PATCH')

        <h3>Order details:</h3>
        <ul>
            <li><b>Country:</b> {{$post->country}} </li>
            <li><b>Address:</b> {{$post->address}} </li>
            <li><b>Zip:</b> {{$post->zip}} </li>
            <li><b>Phone:</b> {{$post->phone}} </li>
            <li><b>Delivery:</b> {{$post->delivery}} </li>
            <li><b>Details:</b> {{$post->details}} </li>
            <li><b>Date:</b> {{$post->created_at}} </li>
        </ul>
        @if($post->products != false)
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
                @foreach($post->products as $product)
                <tr>
                    <td><img src="{{$product->getImageString()}}" alt="product"></td>
                    <td><a href="{{ route('product', $product->slug ) }}">{{$product->name}}</a></td>
                    <td>{{$product->pivot->color}}</td>
                    <td>{{$product->pivot->size}}</td>
                    <td>{{$product->formatted_price}}</td>
                    <td>{{$product->pivot->qty}}</td>
                    <td>{{ $product->formatted_subtotal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div><b>Subtotal:</b> {{ $post->subtotal }} </div>
        <div><b>Discount:</b> - {{ $post->discount }} </div>
        <div><b>Total:</b> {{$post->formatted_total}} </div>
        @else
        <h2>No products!</h2>
        @endif


        <x-select name="status" label="Status" :array="\App\Models\Order::ORDER_STATUSES" :compared="$post->status"/>


        @include('admin.parts.form.button')
    </form>
@endsection
