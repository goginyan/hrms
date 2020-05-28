<div class="form-group">
    <label for="title">{{__('Title')}} *</label>
    <input type="text" required name="title" id="title" value="{{$question->text??""}}" class="form-control">
    <div class="invalid-feedback">
        {{$errors->first('title')??""}}
    </div>
</div>
<div class="form-group">
    <label for="text">{{__('Question')}} *</label>
    <input type="text" required name="text" id="text" value="{{$question->text??""}}" class="form-control">
    <div class="invalid-feedback">
        {{$errors->first('text')??""}}
    </div>
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
    <div class="invalid-feedback @if($errors->has('type')) 'd-block' @endif">
        {{$errors->first('type')}}
    </div>
</div>
<div class="form-group"
     style="{{(isset($question) && $question->type === 'text') || empty($question)?'display:none;':''}}">
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
    <div class="invalid-feedback @if($errors->has('answers')) 'd-block' @endif">
        {{$errors->first('answers')}}
    </div>
    <small>{{__('For "Rating Scale" type of question input 2 number value (min, max) or it will be 0 and 100 by default')}}</small>
</div>
<div class="form-group"
     style="{{(isset($question) && $question->type === 'text') || empty($question)?'display:none;':''}}">
    <label for="right_answers">{{ __('Right Answers') }}</label>
    <select name="right_answers[]" data-width="100%" data-placeholder="{{__('Select Right Answer(s)')}}"
            id="right_answers" multiple class="form-control custom-select">
        @isset($question)
            @forelse($question->right_answers as $answer)
                <option value="{{$answer}}" selected>
                    {{$answer}}
                </option>
            @empty
            @endforelse
        @endisset
    </select>
    <div class="invalid-feedback @if($errors->has('right_answers')) 'd-block' @endif">
        {{$errors->first('right_answers')}}
    </div>
</div>
<div class="form-group"
     style="{{(isset($question) && $question->type === 'text') || empty($question)?:"display:none;"}}">
    <label for="right_answer">{{ __('Right Answer') }}</label>
    <textarea class="form-control" name="right_answer" id="right_answer" cols="30"
              rows="10">{{isset($question) && $question->type === 'text'?$question->right_answers[0]:''}}</textarea>
    <div class="invalid-feedback">
        {{$errors->first('right_answer')??""}}
    </div>
</div>