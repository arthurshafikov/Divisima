<div class="modal-header">
    <h5 class="modal-title">Please select product attributes</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="attribute-select-body product-attributes">
    <div class="quantity">
        <p>Quantity</p>
        <div class="pro-qty"><input type="text" value="1" class="qty"></div>
    </div>

    @foreach ($attributeVariations as $attributeName => $variations)

        @if ($attributeName === 'size')
            <div class="fw-size-choose choose-radio">
                <p>Size</p>
                @foreach ($variations as $size)
                    <div class="sc-item choose-item">
                        <input type="radio" name="size" id="{{ $size->name }}-size" value="{{ $size->name }}">
                        <label for="{{ $size->name }}-size">{{ $size->name }}</label>
                    </div>
                @endforeach
            </div>
        @elseif ($attributeName === 'color')
            <div class="fw-color-choose choose-radio">
                <p>Color</p>
                @foreach ($variations as $color)
                    <div class="cs-item choose-item">
                        <input type="radio" name="color" id="attr-{{ $color->name }}-color" value="{{ $color->name }}">
                        <label for="attr-{{ $color->name }}-color" class="{{ $color->name }}-color"></label>
                    </div>
                @endforeach
            </div>
        @else
            @if (!in_array($attributeName, ['brand']))
                <select name="{{ $attributeName }}" class="select-attribute">
                    @foreach ($variations as $var)
                        <option value="{{ $var->slug }}"><h4>{{ $var->name }}</h4></option>
                    @endforeach
                </select>
            @endif
        @endif



    @endforeach

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary add-to-cart" href="{{ route('addToCart', $product->id) }}">Add to cart</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
</div>
<script>
    $('select').selectric();
</script>
