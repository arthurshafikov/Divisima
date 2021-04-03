@extends('vendor.app')

@section('title', $title)

@section('content')

	@include('parts.page-info')



	<!-- checkout section  -->
	<section class="checkout-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 order-2 order-lg-1">
					<form action="{{ route('submitOrder') }}" class="checkout-form" method="POST">
						@csrf


						@if($errors->any())
							<div class="error-wrapper col-md-12">
								{!! implode('', $errors->all('<p>:message</p>')) !!}
							</div>
						@endif
						<div class="cf-title">Billing Address</div>
						<div class="row">
							<div class="col-md-7">
								<p>*Billing Information</p>
							</div>
							<!-- <div class="col-md-5">
								<div class="cf-radio-btns address-rb">
									<div class="cfr-item">
										<input type="radio" name="pm" id="one">
										<label for="one">Use my regular address</label>
									</div>
									<div class="cfr-item">
										<input type="radio" name="pm" id="two">
										<label for="two">Use a different address</label>
									</div>
								</div>
							</div> -->
						</div>
						<div class="row address-inputs">
							<div class="col-md-12">
								<input type="text" name="address" placeholder="Address" value="{{ $profile->address ?? ''}}">
								<input type="text" name="country" placeholder="Country" value="{{ $profile->country ?? ''}}">
							</div>
							<div class="col-md-6">
								<input type="text" name="zip" placeholder="Zip code" value="{{ $profile->zip ?? ''}}">
							</div>
							<div class="col-md-6">
								<input type="text" name="phone" placeholder="Phone no." value="{{ $profile->phone ?? ''}}">
							</div>
						</div>

							<div class="cf-title">Account Details</div>
							<div class="row account-inputs">
								<div class="col-md-12">
									<input type="text" name="first_name" placeholder="First Name" value="{{ $profile->first_name ?? ''}}">
									<input type="text" name="surname" placeholder="Surname" value="{{ $profile->surname ?? ''}}">
								</div>
								@guest
								<div class="col-md-12">
									<input type="email" name="email" placeholder="Email address">
									<input type="text" name="name" placeholder="Username">
								</div>
								
								<div class="col-md-12">
									<div class="column-input">
										<input type="password" name="password" placeholder="Password">
									</div>
									<div class="column-input">
										<input type="password" name="password_confirmation" placeholder="Repeat Password" >
									</div>
								</div>
								<div class="col-md-12">
									<p>Already have an account? <a href="{{ route('login',['redirect_to'=>url()->full()]) }}">Sign In</a></p>
								</div>
								@endguest
							</div>

						@if($delivery)
							<div class="cf-title">Delievery Info</div>
							<div class="row shipping-btns">
								@foreach($delivery as $id => $del)
									
									<div class="col-12">
										<div class="cf-radio-btns">
											<div class="cfr-item">
												<input type="radio" name="delivery" value="{{$del}}" id="ship-{{ $id }}" checked>
												<label for="ship-{{ $id }}">{{$del}}</label>
											</div>
										</div>
									</div>
								@endforeach
								<!-- <div class="col-6">
									<h4>Next day delievery  </h4>
								</div>
								<div class="col-6">
									<div class="cf-radio-btns">
										<div class="cfr-item">
											<input type="radio" name="delivery" value="1" id="ship-2">
											<label for="ship-2">$3.45</label>
										</div>
									</div>
								</div> -->
							</div>
						@endif
						<div class="cf-title">Additional Info</div>
						<div class="row shipping-btns">
							<div class="col-md-12">
								<textarea class="form-control" id="exampleFormControlTextarea1" name="additional" rows="3">Test</textarea>
							</div>
						</div>


						<!-- <div class="cf-title">Payment</div>
						<ul class="payment-list">
							<li>Paypal<a href="#"><img src="img/paypal.png" alt=""></a></li>
							<li>Credit / Debit card<a href="#"><img src="img/mastercart.png" alt=""></a></li>
							<li>Pay when you get the package</li>
						</ul> -->
						<button type="submit" class="site-btn submit-order-btn">Place Order</button>
					</form>
				</div>
				<div class="col-lg-4 order-1 order-lg-2">
					<div class="checkout-cart">
						<h3>Your Cart</h3>
						<ul class="product-list">
                            @foreach($items as $product)
                                <li>
                                    <div class="pl-thumb"><img src="{{ $product->img() }}" alt=""></div>
                                    <h6>{{ $product->name }}</h6>
                                    <p>${{ $product['total'] }}</p>
                                    <p>Size: {{ $product['size'] ?? '-' }}</p>
                                    <p>Color: {{ $product['color'] ?? '-' }}</p>
                                </li>
                            @endforeach
						</ul>
						<ul class="price-list">
							<li>Subtotal<span>${{ number_format($subtotal,2) }}</span></li>
							<li>Discount<span>${{ number_format($discount,2) }}</span></li>
							<li>Shipping<span>free</span></li>
							<li class="total">Total<span>${{ $total }}</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- checkout section end -->

@endsection