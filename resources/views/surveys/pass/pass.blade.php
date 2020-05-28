@extends('layouts.dashboard')

@section('title',$survey->title)

@section('content')
    <form action="{{route('surveys.pass.store', $survey)}}" method="post">
        @csrf
        @foreach($survey->questions as $question)
            <div class="form-group">
                <label for="question{{$question->id}}"><h5><i>{{$question->text}}</i></h5></label>
                @switch($question->type)
                    @case('range')
                    <label for="question{{$question->id}}" class="d-flex justify-content-between">
                        <small>{{$question->answers[0]??0}}</small>
                        <small>{{$question->answers[1]??100}}</small>
                    </label>
                    <div class="position-relative">
                        <input required min="{{$question->answers[0]??0}}" max="{{$question->answers[1]??100}}" step="1"
                               type="range"
                               class="custom-range" id="question{{$question->id}}" name="{{$question->id}}">
                        <output for="{{$question->id}}" onforminput="value = foo.valueAsNumber;"></output>
                    </div>
                    @break
                    @case('checkbox')
                    @foreach($question->answers as $key => $answer)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   id="q{{$question->id}}answer{{$key}}"
                                   name="{{$question->id}}[]" value="{{$answer}}">
                            <label class="custom-control-label"
                                   for="q{{$question->id}}answer{{$key}}">{{$answer}}</label>
                        </div>
                    @endforeach
                    @break
                    @case('radio')
                    @foreach($question->answers as $key => $answer)
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input"
                                   id="q{{$question->id}}answer{{$key}}"
                                   name="{{$question->id}}" value="{{$answer}}">
                            <label class="custom-control-label"
                                   for="q{{$question->id}}answer{{$key}}">{{$answer}}</label>
                        </div>
                    @endforeach
                    @break
                    @case('text')
                    <textarea required class="form-control" name="{{$question->id}}" id="question{{$question->id}}"
                              rows="10"></textarea>
                    @break
                @endswitch
            </div>
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
        </div>
    </form>
@endsection