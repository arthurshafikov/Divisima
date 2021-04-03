@extends('admin.vendor.admin')

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Options</h1>

    @include('admin.parts.breadcrumbs')
    
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-body">
        <form method="POST" action="{{ route('options.update') }}">
            @csrf

            @foreach($options as $option)
                @if(!is_array($option->value))
                    <div class="form-group">
                        <label class="small mb-1">{{ $option->name() }}</label>
                        <input class="form-control py-4" type="text" name="{{ $option->key }}" value="{{ $option->value }}"/>
                    </div>
                @else 
                    <div class="form-group">
                        <label class="small mb-1">{{ $option->name() }}</label>
                        @foreach($option->value as $value)
                            <input class="form-control py-4" type="text" name="{{ $option->key }}[]" value="{{ $value }}"/>
                        @endforeach
                    </div>
                @endif
            @endforeach
            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>

</div>
@endsection