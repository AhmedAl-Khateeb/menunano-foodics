@props(['type','label' => '','name','value' => ''])

    @if($label != '')
        <label for="{{$label}}">{{$label}}</label>
    @endif
    <input type="{{$type}}" value="{{old($name,$value)}}" name="{{$name}}" id="{{$label}}" {{
        $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name)
        ])
    }}>
    @error($name)
    <div class="text-danger invalid-feedback">
        {{$message}}
    </div>
    @enderror
