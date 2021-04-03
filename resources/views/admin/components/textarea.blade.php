<div class="form-group">
    @if($label != '')
        <label class="small mb-1">{{ $label }}</label>
    @endif 
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control" placeholder="{{ $placeholder }}">{{$value}}</textarea>
</div>