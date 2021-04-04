@extends('admin.vendor.crud')

@section('form')


<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <x-input :value="old('name')" placeholder="Name of the product" label="Name" />

    <x-image :value="old('img')" :src="App\Models\Image::find(old('img'))?->img"/>


    <div class="form-group">
        <label class="small mb-1">Product Gallery</label>

        <input type="hidden" name="gallery" value="{{ old('gallery') }}" class="form-control py-4 hidden-img">
        <a data-fancybox data-src="#media" href="javascript:;" class="media-load">Select Images</a>

        <div class="gallery-wrapper">
            <div class="gallery">
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


    <div class="form-group">
        <label class="small mb-1">Attributes</label>
        <div class="attributes-wrapper">
            <ul>
                @foreach (getAllAttributes() as $attribute)
                    <li class="attribute-name">{{ $attribute->name }}</li>
                    @if (count($attribute->variations) > 0 )
                    <ul class="sub-menu">
                        @foreach ($attribute->variations as $var)
                        <li><input type="checkbox" name="attributes[]" id="var_{{ $var->id }}" value="{{ $var->id }}" {{ echoCheckedIfOldHas($var->id,'attributes') }}> <label for="var_{{ $var->id }}">{{ $var->name }}</label> </li>
                        @endforeach
                    </ul>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>


    <div class="form-group">
        <label class="small mb-1">Categories</label>
        <div class="attributes-wrapper">
            <ul>
                @foreach (getAllParentCategories() as $category)
                <li class="attribute-name"><input type="checkbox" name="category[]" id="cat_{{ $category->id }}" value="{{ $category->id }}" {{ echoCheckedIfOldHas($category->id,'category') }} >
                 <label for="cat_{{ $category->id }}">{{ $category->name }}</label>
                </li>
                @if (count($category->childs) > 0 )
                <ul class="sub-menu">
                    @foreach ($category->childs as $cat)
                    <li><input type="checkbox" name="category[]" id="cat_{{ $cat->id }}" value="{{ $cat->id }}" {{ echoCheckedIfOldHas($cat->id,'category') }}> <label for="cat_{{ $cat->id }}">{{ $cat->name }}</label> </li>
                    @endforeach
                </ul>
                @endif
                @endforeach
            </ul>
        </div>
    </div>

    <x-select name="stock" label="Stock" :array="getOptions('stock_status')" :compared="old('stock')"/>

    
    @include('admin.parts.form.button')
</form>
@endsection