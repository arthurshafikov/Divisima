@extends('vendor.app')

@section('title', $title)

@section('content')
	@include('parts.slider')

	@include('parts.features')

	<!-- letest product section -->
	<section class="top-letest-product-section">
		<div class="container">
			<div class="section-title">
				<h2>LATEST PRODUCTS</h2>
			</div>
			<div class="product-slider owl-carousel">
				@forelse ($products as $product)
					@include('parts.product.product')
				@empty
					There is no products!
				@endforelse
			</div>
		</div>
	</section>
	<!-- letest product section end -->

	@include('parts.product.top-selling')

	@include('parts.banner')

@endsection
