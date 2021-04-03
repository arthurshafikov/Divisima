<div class="form-group">
    <label class="small mb-1">{{ $label }}</label>
    <input class="form-control py-4" type="hidden" name="{{ $name }}" id="{{ $input_id }}" value="{{$value}}" />
    
    <a data-fancybox data-src="#media" href="javascript:;" class="media-load single-image">{{ $selectText }}</a>
    <div class="admin-image-wrapper">
        <img src="{{ $src }}" alt="Please select image to preview" id="{{ $img_id }}">
    </div>
</div>

