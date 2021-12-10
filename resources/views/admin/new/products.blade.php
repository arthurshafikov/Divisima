@extends('admin.vendor.crud')

@section('form')


<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <x-input :value="old('name')" placeholder="Name of the product" label="Name" />

    <x-image :value="old('image_id')" :src="App\Models\Image::find(old('image_id'))?->src"/>


    <div class="form-group">
        <label class="small mb-1">Product Gallery</label>

        <input type="hidden" name="gallery" value="{{ old('gallery') }}" class="form-control py-4 hidden-img">
        <a data-fancybox data-src="#media" href="javascript:;" class="media-load">Select Images</a>

        <div class="gallery-wrapper">
            <div class="gallery" data-url="{{ route('loadGallery') }}">
                @if (old('gallery'))
                    @foreach (\App\Models\Image::whereIn('id',explode(',',old('gallery')))->get() as $img)
                        @include('admin.parts.gallery-image')
                    @endforeach
                @endif
            </div>
        </div>

    </div>

    <x-input type="number" name="price" :value="old('price')" placeholder="Price of the product" label="Price" />

    <x-textarea label="Details" name="details" placeholder="Details of the product" :value="old('details')" />

    <x-textarea label="Description" name="description" placeholder="Description of the product" :value="old('description')" />

    <x-attributes/>

    <x-categories/>

    <x-select name="stock" label="Stock" :array="App\Models\Product::PRODUCT_STOCK_STATUSES" :compared="old('stock')"/>

    @include('admin.parts.form.button')
</form>
@endsection
