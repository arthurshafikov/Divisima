@foreach($products as $product)
    <div class="col-lg-3 col-sm-6">
        @include('parts.product.product')
    </div>
@endforeach