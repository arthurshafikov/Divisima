<div class="form-group">
    @if ($label !== '')
        <label class="small mb-1">{{ $label }}</label>
    @endif
    <select name="{{ $name }}" class="form-control" id="">
        @if ($default != false)
            <option value="">{{ $default }}</option>
        @endif
        @foreach ($array as $element)
            @if(is_object($element))
                <option value="{{$element->$field}}" {{ $echoSelectedIfEquals($element->$field) }} >{{$element->$labelField}}</option>
            @else 
                <option value="{{$element}}" {{ $echoSelectedIfEquals($element) }} >{{snakeCaseToNormal($element)}}</option>
            @endif
        @endforeach
    </select>
</div>
