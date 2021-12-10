<div class="form-group">
    <label class="small mb-1">Categories</label>
    <div class="attributes-wrapper">
        <ul>
            @foreach (\App\Models\Category::parents()->with('childs')->get() as $category)
                <li class="attribute-name"><input type="checkbox" name="category[]" id="cat_{{ $category->id }}" value="{{ $category->id }}" {{ checkedIfOldHas($category->id,'category') }} >
                    <label for="cat_{{ $category->id }}">{{ $category->name }}</label>
                </li>
                @if (count($category->childs) > 0 )
                    <ul class="sub-menu">
                        @foreach ($category->childs as $cat)
                            <li><input type="checkbox" name="category[]" id="cat_{{ $cat->id }}" value="{{ $cat->id }}"
                                @if (old('attributes') !== null && count(old('attributes')) > 0)
                                    {{ checkedIfOldHas($cat->id, 'category') }}
                                @else
                                    {{ checkedIfModelHas($cat->id, $product, 'category') }}
                                @endif
                                <label for="cat_{{ $cat->id }}"> {{ $cat->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        </ul>
    </div>
</div>
