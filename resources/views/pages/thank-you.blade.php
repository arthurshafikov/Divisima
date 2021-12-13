@extends('vendor.app')

@section('title',$title)

@section('content')

    <section class="contact-section">
		<div class="container">
			<div class="row">
                <div>
                    <h1>{{$title}}</h1>
                    <p>Checkout your <a href="{{ route('order', $orderId) }}">order</a>!</p>
                </div>

            </div>
        </div>
    </section>

	@include('parts.product.recently-viewed')

@endsection
