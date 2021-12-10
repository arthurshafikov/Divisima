<div class="form-group">
    <label class="small mb-1">Attributes</label>
    <div class="attributes-wrapper">
        <ul>
            @foreach (\App\Models\Attributes\Attribute::with('variations')->get() as $attribute)
                <li class="attribute-name">{{ $attribute->name }}</li>
                @if (count($attribute->variations) > 0 )
                    <ul class="sub-menu">
                        @foreach ($attribute->variations as $var)
                            <li>
                                <input type="checkbox" name="attributes[]" id="var_{{ $var->id }}" value="{{ $var->id }}"
                                   @if (old('attributes') !== null && count(old('attributes')) > 0)
                                       {{ checkedIfOldHas($var->id, 'attributes') }}
                                   @else
                                       {{ checkedIfModelHas($var->id, $product, 'attributeVariations') }}
                                   @endif
                                    >
                                <label for="var_{{ $var->id }}">{{ $var->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        </ul>
    </div>
</div>
