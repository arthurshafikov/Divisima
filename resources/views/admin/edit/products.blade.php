@extends('admin.vendor.crud')

@section('form')
<a href="{{ route('product',$post->slug) }}" target="_blank">View product</a>


<form method="POST" action="{{ route('products.update',$post->id) }}">
    @csrf
    @method('PATCH')

    <x-input :value="$post->name" placeholder="Name of the product" label="Name" />

    <x-image :value="$post->image?->id" :src="$post->getImageString()"/>

    <div class="form-group">
        <label class="small mb-1">Product Gallery</label>

        <input type="hidden" name="gallery" value="{{ $post->images->implode('id',',') }} " class="form-control py-4 hidden-img">
        <a data-fancybox data-src="#media" href="javascript:;" class="media-load">Select Images</a>

        <div class="gallery-wrapper">
            <div class="gallery" data-url="{{ route('loadGallery') }}">
                @foreach ($post->images as $img)
                    @include('admin.parts.gallery-image')
                @endforeach
            </div>
        </div>

    </div>

    <x-input type="number" name="price" :value="$post->price" placeholder="Price of the product" label="Price" />

    <x-textarea label="Details" name="details" placeholder="Details of the product" :value="$post->details" />

    <x-textarea label="Description" name="description" placeholder="Description of the product" :value="$post->description" />

    <x-attributes :product="$post"/>

    <x-categories :product="$post"/>

    <x-select name="stock" label="Stock" :array="App\Models\Product::PRODUCT_STOCK_STATUSES" :compared="$post->stock"/>

    @include('admin.parts.form.button')
</form>
@endsection
