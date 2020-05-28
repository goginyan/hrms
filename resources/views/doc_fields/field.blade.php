<div class="form-group">
    @php
        $name = empty($formName)?trim(str_replace(' ','_', $label)):$formName;
        $val = isset($value)?$value:null;
        $required = !empty($fieldRequired)?"required":"";
    @endphp
    @switch($type)
        @case('checkbox')
        <div class="custom-control custom-checkbox">
            <input {{$required}} name="{{$name}}" {{$val?"checked":""}} type="checkbox" class="custom-control-input"
                   id="{{$id}}">
            <label class="custom-control-label" for="{{$id}}">{{$label}}</label>
        </div>
        @break

        @case('textarea')
        @empty ($noLabel)
            <label for="{{$id}}">
                {{$label}}
            </label>
        @endempty
        <textarea {{$required}} id="{{$id}}" name="{{$name}}"
                  class="form-control {{$errors->has($name)?"is-invalid":""}}"
                  rows="3">{{$val??""}}</textarea>
        <div class="invalid-feedback">
            {{$errors->first($name)??""}}
        </div>
        @break

        @case('file')
        <div class="custom-file">
            <input {{$required}} name="{{$name}}" type="file" class="custom-file-input" id="{{$id}}">
            <label class="custom-file-label" for="{{$id}}">{{$label}}</label>
        </div>
        @break

        @default
        @empty ($noLabel)
            <label for="{{$id}}">
                {{$label}}
            </label>
        @endempty
        <input {{$required}} type="{{$type}}" value="{{$val??""}}" id="{{$id}}" name="{{$name}}"
               class="form-control {{$errors->has($name)?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first($name)??""}}
        </div>
    @endswitch
</div>
