@if (session('msg'))
    <div class="col-md-12 alert alert-success">
        <p>{{ session('msg') }}</p>
    </div>
@endif 

@if (session('err'))
    <div class="col-md-12 alert alert-danger">
        <p>{{ session('err') }}</p>
    </div>
@endif 