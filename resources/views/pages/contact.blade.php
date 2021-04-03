@extends('vendor.app')

@section('title',$title)

@section('content')

	@include('parts.page-info')


	<!-- Contact section -->
	<section class="contact-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 contact-info">
					<h3>Get in touch</h3>
					<p>{{ getOption('company_address') }}</p>
					<p>{{ getOption('company_phone') }}</p>
					<p>{{ getOption('company_email') }}</p>
					<div class="contact-social">
						<a href="{{ getOption('pinterest_link') }}"><i class="fa fa-pinterest"></i></a>
						<a href="{{ getOption('facebook_link') }}"><i class="fa fa-facebook"></i></a>
						<a href="{{ getOption('twitter_link') }}"><i class="fa fa-twitter"></i></a>
						<a href="{{ getOption('instagram_link') }}"><i class="fa fa-instagram"></i></a>
						<a href="{{ getOption('google_link') }}"><i class="fa fa-google-plus"></i></a>
					</div>
					<form class="contact-form" action="{{ route('contactEmail') }}">
						<div class="preloader">
							<div class="loader"></div>
						</div>	
						<div class="form-errors"></div>
						@csrf
						<input type="text" name="name" placeholder="Your name">
						<input type="text" name="email" placeholder="Your e-mail">
						<input type="text" name="subject" placeholder="Subject">
						<textarea name="message" placeholder="Message"></textarea>
						<button type="submit" class="site-btn">SEND NOW</button>
					</form>
				</div>
			</div>
		</div>
		<div class="map"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14376.077865872314!2d-73.879277264103!3d40.757667781624285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1546528920522" style="border:0" allowfullscreen></iframe></div>
	</section>
	<!-- Contact section end -->


	@include('parts.product.recently-viewed')


@endsection