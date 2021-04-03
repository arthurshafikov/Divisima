@extends('admin.vendor.admin')

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">{{ $post->title ?? 'New' }}</h1>

    @include('admin.parts.breadcrumbs')
    
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-body">
        @include('admin.parts.errors')
        @yield('form')
    </div>

</div>



@endsection