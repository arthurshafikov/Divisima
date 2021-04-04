@extends('vendor.app')

@section('title',$errorMessage)

@section('content')

    <section class="error-page">
        <div class="container">
            <div class="row">
                <h1>{{ $errorCode }} {{ $errorMessage }}</h1>

            </div>
        </div>
    </section>

    @include('parts.product.recently-viewed')

@endsection