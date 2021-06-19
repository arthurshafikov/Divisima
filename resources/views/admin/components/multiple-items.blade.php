<div class="form-group">
    <label class="small mb-1">Items</label>
    <div class="btn btn-primary new-item">New item</div>
    <div class="multipleItems">
        <label class="item-example" for="">
            @if(!is_array($name))
                <input class="form-control py-4" type="text" name="{{$name}}[]" placeholder="{{$placeholder}}" value="" disabled/>
            @else 
                @foreach($name as $el)
                    <input class="form-control py-4" type="text" name="{{$el}}[]" placeholder="{{$placeholder[$loop->index]}}" value="" disabled/>
                @endforeach 
            @endif 
            <div class="remove-item btn-danger"><i class="fas fa-times"></i></div>
        </label>

        @if($post !== null && !$errors->count())
            @foreach($post->$iterable as $item)
                <label for="">
                    @if(!is_array($name))
                        <input class="form-control py-4" type="text" name="{{$name}}[]" placeholder="{{$placeholder}}" value="{{ $item->name }}" />
                    @else 
                        @foreach($name as $el)
                            <input class="form-control py-4" type="text" name="{{$el}}[]" placeholder="{{$placeholder[$loop->index]}}" value="{{ $item->{$columns[$loop->index]} }}" />
                        @endforeach 
                    @endif 
                    
                    <div class="remove-item btn-danger"><i class="fas fa-times"></i></div>
                </label>
            @endforeach 
        @endif

        @php 
            $oldname = $name;
            if(is_array($name)){
                $oldname = $name[0];
            }
        @endphp

        @if(old($oldname))
            @for($i = 0; $i < count(old($oldname)); $i++) 
                <label for="">
                    @if(!is_array($name))
                        <input class="form-control py-4" type="text" name="{{$name}}[]" placeholder="{{$placeholder}}" value="{{ old($name)[$i] }}"/>
                    @else 
                        @foreach($name as $el)
                            <input class="form-control py-4" type="text" name="{{$el}}[]" placeholder="{{$placeholder[$loop->index]}}" value="{{ old($el)[$i] }}"/>
                        @endforeach 
                    @endif 

                    <div class="remove-item btn-danger"><i class="fas fa-times"></i></div>
                </label>
            @endfor
        @endif
    </div>
</div>
