<div class="form-group">
    <label for="text">{{__('Question')}} *</label>
    <input type="text" required name="text" id="text" value="{{$question->text??""}}" class="form-control">
</div>
<div class="form-group">
    <label for="type">{{ __('Type') }} *</label>
    <select data-width="100%" class="form-control custom-select"
            name="type" required
            id="type">
        @foreach($types as $key=>$value)
            <option {{isset($question) && $question->type==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="answers">{{ __('Answers') }}</label>
    <select name="answers[]" data-placeholder="{{__('Select Answers')}}"
            id="answers" multiple class="form-control tags-select">
        @isset($question)
            @if (is_array($question->answers))
                @foreach($question->answers as $answer)
                    <option value="{{$answer}}" selected>
                        {{$answer}}
                    </option>
                @endforeach
            @endif
        @endisset
    </select>
    <small>{{__('For "Rating Scale" type of question input 2 number value (min, max) or it will be 0 and 100 by default')}}</small>
</div>