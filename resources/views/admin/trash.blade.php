@extends('admin.vendor.admin')

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Trash</h1>
    @include('admin.parts.breadcrumbs')

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (\Illuminate\Support\Facades\Route::has($essence . '.create'))
        <a href="{{ route($essence . '.create')}}" class="btn btn-primary">
            New {{ ucfirst($essence) }}
        </a>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @foreach ($th as $label)
                                <th>{{ $label }}</th>
                            @endforeach
                            <th>Restore</th>
                            <th>Delete Permanently</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            @foreach ($th as $label)
                                <th>{{ $label }}</th>
                            @endforeach
                            <th>Restore</th>
                            <th>Delete Permanently</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                @foreach ($td as $col)
                                    <td>{!! $post->$col !!}</td>
                                @endforeach
                                <td><a href="{{ route($essence . '.restore',$post->id) }}" class="btn btn-primary">Restore</a></td>
                                <td>
                                    <form method="POST" action="{{ route($essence . '.forceDelete',$post->id)}}" onSubmit="if(!confirm('Are you sure to delete permanently this item?')){return false;}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
