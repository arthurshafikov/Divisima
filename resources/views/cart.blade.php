@extends('vendor.app')

@section('title', $title)

@section('content')
	@include('parts.page-info')

	<!-- cart section end -->
	<section class="cart-section spad">
		<div class="container">
			@include('parts.cart.cart')

		</div>
	</section>
	<!-- cart section end -->

	@include ('parts.product.recently-viewed')
@endsection
