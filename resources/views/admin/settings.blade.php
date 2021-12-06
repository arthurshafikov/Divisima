@extends('admin.vendor.admin')

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Settings</h1>

    @include('admin.parts.breadcrumbs')

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-body">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf

            @foreach ($settings as $key => $setting)
                <div class="form-group">
                    <label class="small mb-1">{{ $key }}</label>
                    <input class="form-control py-4" type="text" name="{{ $key }}" value="{{ $setting }}"/>
                </div>
            @endforeach
            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>

</div>
@endsection
