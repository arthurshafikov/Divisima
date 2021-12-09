@extends('vendor.app')

@section('title',$title)

@section('content')

    <section class="contact-section">
		<div class="container">
			<div class="row">
                <div class="w-100 profile-info-wrapper">
                    <h1>{{ $title }} </h1>

                    <div class="row">
                        <div class="col-md-6 avatar-wrapper">
                            <img src="{{ $profile->image->src ?? $defaultAvatar }}" alt="avatar" id="avatar">
                            <button data-fancybox data-src="#upload-avatar" href="javascript:;" class="site-btn upload-avatar">Upload avatar</button>
                        </div>
                        <div class="col-md-6">
                            <p>Name: {{ $profile->first_name }} </p>
                            <p>Surname: {{ $profile->surname }} </p>
                            <p>Address: {{ $profile->address }} </p>
                            <p>Country: {{ $profile->country }} </p>
                            <p>Zip: {{ $profile->zip }} </p>
                            <p>Phone: {{ $profile->phone }} </p>

                            <button data-fancybox data-src="#change-profile" href="javascript:;" class="site-btn change-profile">Change info</button>

                            <p class="gray">
                                <small>P.S This information will be used during checkout</small>
                            </p>
                        </div>
                    </div>

                </div>

                @if ($orders != false)
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Address</th>
                            <th scope="col">Delivery</th>
                            <th scope="col">Created</th>
                            <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th scope="row">{{$order->id}}</th>
                                    <td>{{$order->status_text}}</td>
                                    <td>{{$order->address}}</td>
                                    <td>{{$order->delivery_text}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td><a href="{{ route('order', $order->id ) }}">View<a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h2>No orders!</h2>
                @endif
            </div>
        </div>
    </section>


    <div style="display: none;" id="upload-avatar" class="popup">
		<div class="preloader">
			<div class="loader"></div>
		</div>
		<h2>Upload:</h2>
		<div class="upload-form">
            <form action="{{ route('upload-avatar') }}" id="upload-avatar-form">
                <div class="form-errors"></div>
                @csrf
                <div class="form-group">
                    <label>Avatar</label>
                    <div class="avatar-preview">
                        <img src="" alt="" class="preview-avatar" id="preview-avatar">
                    </div>
                    <input type="file" name="avatar" id="avatar-file">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
		</div>
	</div>

    <div style="display: none;" id="change-profile" class="popup">
		<div class="preloader">
			<div class="loader"></div>
		</div>
		<h2>Upload:</h2>
		<div class="upload-forcx m">
            <form action="{{ route('change-profile') }}" method="POST" id="change-profile-form">
                <div class="form-errors">

                </div>
                @csrf
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ $profile->first_name }}">
                </div>
                <div class="form-group">
                    <label>Surname</label>
                    <input type="text" class="form-control" name="surname" placeholder="Surname" value="{{ $profile->surname }}">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Address" value="{{ $profile->address }}">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" name="country" placeholder="Country" value="{{ $profile->country }}">
                </div>
                <div class="form-group">
                    <label>Zip</label>
                    <input type="text" class="form-control" name="zip" placeholder="Zip" value="{{ $profile->zip }}">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ $profile->phone }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
		</div>
	</div>

	@include('parts.product.recently-viewed')


@endsection
