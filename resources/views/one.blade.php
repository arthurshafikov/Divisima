@extends('vendor.app')

@section('title', $title)

@section('content')
	@include('parts.page-info')

	<!-- product section -->
	<section class="product-section">
		<div class="container">
			<div class="back-link">
				<a href="./category.html"> &lt;&lt; Back to Category</a>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="product-pic-zoom">
						<img class="product-big-img" src="{{ $product->img() }}" alt="">
                    </div>

					<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
						<div class="product-thumbs-track">
							@foreach ($product->images as $img)
								<div class="pt" data-imgbigurl="{{ $img->img }}"><img src="{{ $img->img }}" alt=""></div>
							@endforeach
						</div>
                    </div>

				</div>
				<div class="col-lg-6 product-details">
					<h3>Category: </h3>
					<p>
						@foreach ($product->category as $category)
							{{ $category->name }}
						@endforeach
					</p>
					<h2 class="p-title">{{ $product->name }}</h2>
					<h3 class="p-price">{{ $product->formatted_price }}</h3>
					<h4 class="p-stock">Available: <span>{{ $product->stock_status }}</span></h4>
					<div class="p-rating">
						@for ($i = 1; $i <= 5; $i++)
							@if($i > $rating)
								<i class="fa fa-star-o fa-fade"></i>
							@else
								<i class="fa fa-star-o"></i>
							@endif
						@endfor
					</div>
					<div class="p-review">
						<a data-src="#reviews" href="{{ route('getReviews',$id) }}" onclick="return false" class="reviews-load">{{ $ratingCount }} reviews</a>|<a data-fancybox data-src="#add-review" href="javascript:;"> Add your review</a>
                    </div>


					@if ($sizes->count() > 0)
						<div class="fw-size-choose choose-radio">

							<p>Size</p>
							@foreach ($sizes as $size)
								<div class="sc-item choose-item">
									<input type="radio" name="size" id="{{ $size->name }}-size" value="{{ $size->name }}">
									<label for="{{ $size->name }}-size">{{ $size->name }}</label>
								</div>
							@endforeach


						</div>
					@endif

					@if ($colors->count() > 0)
						<div class="fw-color-choose choose-radio">

							<p>Colors</p>
							@foreach ($colors as $color)
								<div class="cs-item choose-item">
									<input type="radio" name="color" id="{{ $color->name }}-color" value="{{ $color->name }}">
									<label for="{{ $color->name }}-color" class="{{ $color->name }}-color"></label>
								</div>
							@endforeach

						</div>
					@endif

					@if ($brands->count() > 0)
						<div class="product-brands">
							<p>Brands: </p>
							{{ $brands->implode('name',', ') }}
						</div>
					@endif
					<br>
					<div class="quantity">
						<p>Quantity</p>
                        <div class="pro-qty"><input type="text" value="1" class="qty"></div>
                    </div>
					<a href="{{ route('addToCart',$product->id) }}" class="add-cart site-btn"><span>ADD TO CART</span></a>
					<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">information</button>
							</div>
							<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
									{{ $product->description }}
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">care details </button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
								<div class="panel-body">
									<!-- <img src="/img/cards.png" alt=""> -->
									{{ $product->details }}
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingThree">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
							</div>
							<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
								<div class="panel-body">

									<!-- <h4>7 Days Returns</h4>
									<p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p> -->
									{!! setting('shipping_return_info') !!}
								</div>
							</div>
						</div>
					</div>
					<div class="social-sharing">
						<a href="{{ setting('google_link') }}"><i class="fa fa-google-plus"></i></a>
						<a href="{{ setting('pinterest_link') }}"><i class="fa fa-pinterest"></i></a>
						<a href="{{ setting('facebook_link') }}"><i class="fa fa-facebook"></i></a>
						<a href="{{ setting('twitter_link') }}"><i class="fa fa-twitter"></i></a>
						<a href="{{ setting('youtube_link') }}"><i class="fa fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- product section end -->


	@if (count($related) > 0)
		<!-- RELATED PRODUCTS section -->
		<section class="related-product-section">
			<div class="container">
				<div class="section-title">
					<h2>RELATED PRODUCTS</h2>
				</div>
				<div class="product-slider owl-carousel">
					@foreach($related as $product)
						@include('parts.product.product')
					@endforeach
				</div>
			</div>
		</section>
		<!-- RELATED PRODUCTS section end -->
	@endif

	<div style="display: none;" id="add-review" class="popup">
		<div class="preloader">
			<div class="loader"></div>
		</div>
		<h2>Add a review:</h2>
		<div class="form-wrapper">
			<div class="form-errors">

			</div>
			<form action="{{ route('add-review',$id) }}" id="add-review-form">
				@csrf
				<div class="form-group">
					<label for="exampleInputEmail1">Rating</label>
					<div class="rate-wrapper">
						<div class="rate">
							<input type="radio" id="star-5" name="rating" value="5">
							<label for="star-5" title="Rate «5»"><i class="fa fa-star-o"></i></label>
							<input type="radio" id="star-4" name="rating" value="4">
							<label for="star-4" title="Rate «4»"><i class="fa fa-star-o"></i></label>
							<input type="radio" id="star-3" name="rating" value="3">
							<label for="star-3" title="Rate «3»"><i class="fa fa-star-o"></i></label>
							<input type="radio" id="star-2" name="rating" value="2">
							<label for="star-2" title="Rate «2»"><i class="fa fa-star-o"></i></label>
							<input type="radio" id="star-1" name="rating" value="1">
							<label for="star-1" title="Rate «1»"><i class="fa fa-star-o"></i></label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Review</label>
					<textarea name="text" id=""></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>

	<div style="display: none;" id="reviews" class="popup">
		<div class="preloader active">
			<div class="loader"></div>
		</div>
		<h2>Reviews:</h2>
		<div class="reviews-wrapper">

		</div>

	</div>

	@include('parts.banner')

@endsection
