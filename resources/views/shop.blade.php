@extends('vendor.app')

@section('title', $title)

@section('content')

@include('parts.page-info')


<!-- Category section -->
<section class="category-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 order-2 order-lg-1">

				<form action="" class='filter-form' method="GET">
					<div class="filter-widget">
						<h2 class="fw-title">Categories</h2>

						{!! $menu !!}
					</div>


					<div class="filter-widget mb-0">
						<h2 class="fw-title">refine by</h2>
						<div class="price-range-wrap">
							<h4>Price</h4>
							<div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="{{ $min_price }}" data-max="{{ $max_price }}">
								<div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
								<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;">
								</span>
								<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;">
								</span>
							</div>
							<div class="range-slider">
								<div class="price-input">
									<input type="text" name="price_min" id="minamount" >
									<input type="text" name="price_max" id="maxamount" >
								</div>
							</div>
						</div>
					</div>
					<div class="filter-widget mb-0">
						<h2 class="fw-title">color by</h2>
						<div class="fw-color-choose choose-radio">
							@foreach(getAttributesByName('color') as $color)
								<div class="cs-item choose-item">
									<input type="radio" name="color" value="{{ $color->slug }}" id="{{ $color->slug }}-color" @if($color->active === 1) {{'checked'}} @endif>
									<label class="cs-{{ $color->slug }}" for="{{ $color->slug }}-color">
									</label>
									<!-- <span>({{--$color->products_count--}})</span> -->
								</div>
							@endforeach
						</div>
					</div>
					<div class="filter-widget mb-0">
						<h2 class="fw-title">Size</h2>
						<div class="fw-size-choose choose-radio">
							@foreach(getAttributesByName('size') as $size)
								<div class="sc-item choose-item">
									<input type="radio" name="size" value="{{ $size->slug }}" id="{{ $size->slug }}" @if($size->active === 1) {{'checked'}} @endif>
									<label for="{{ $size->slug }}">{{  $size->name }}</label>
								</div>
							@endforeach
							
						</div>
					</div>
					<div class="filter-widget">
						<h2 class="fw-title">Brand</h2>
						<ul class="category-menu">
							@foreach(getAttributesByName('brand') as $brand)
								<li>
									<input type="checkbox" name="brand[]" value="{{ $brand->slug }}" id="{{ $brand->slug }}" @if($brand->active === 1) {{'checked'}} @endif>
									<label for="{{ $brand->slug }}">{{ $brand->name }} <!--<span>({{-- $brand->products_count--}})</span>--></label>
								</li>
							@endforeach
							<!-- <li><a href="#">Asos<span>(56)</span></a></li>
							<li><a href="#">Bershka<span>(36)</span></a></li>
							<li><a href="#">Missguided<span>(27)</span></a></li>
							<li><a href="#">Zara<span>(19)</span></a></li> -->
						</ul>
					</div>

					<button type="submit" class="btn btn-primary">Filter</button>
				</form>
			</div>

			<div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
				<div class="row">
					@forelse($products as $product)
					<div class="col-lg-4 col-sm-6">
						@include('parts.product.product')
					</div>
					@empty
					<h4>There is no products!</h4>
					@endforelse
					<div class="text-center w-100 pt-3">
						<!-- <button class="site-btn sb-line sb-dark">LOAD MORE</button> -->
						{{ $products->links() }}
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
<!-- Category section end -->


@endsection