@extends('layouts.dashboard')

@section('title', ($quizable->first_name??'No Name') . ($quizable->last_name??'') )

@section('content')
    <div id="accordion">
        @foreach($quiz->questions as $question)
            <div class="card">
                <div class="card-header" id="heading{{$question->id}}">
                    <h5 class="mb-0 d-flex justify-content-between align-items-center">
                        <a href="javascript:void(0);" class="btn-link" data-toggle="collapse"
                           data-target="#collapse{{$question->id}}"
                           aria-expanded="false" aria-controls="collapse{{$question->id}}">
                            <i>{{$question->text}}</i>
                        </a>
                        <span
                            class="badge {{$details[$question->id]['result']?'badge-success':'badge-danger'}} badge-lg"
                            data-toggle="tooltip" data-placement="left"
                            title="{{$details[$question->id]['result']?__('Right'):__('Wrong')}}">&nbsp;</span>
                    </h5>
                </div>
                <div id="collapse{{$question->id}}" class="collapse"
                     aria-labelledby="heading{{$question->id}}" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="list-group list-group-flush interviews-list mt-2">
                            @if($question->answers && $question->type !== 'range')
                                @foreach($question->answers as $index => $answer)
                                    @if($answer==$details[$question->id]['answer'] || (is_array($details[$question->id]['answer']) && in_array($answer,$details[$question->id]['answer'])))
                                        <li class="list-group-item {{in_array($answer,$question->right_answers)?'bg-success text-light':'text-light bg-danger'}}">{{$answer}}</li>
                                    @else
                                        <li class="list-group-item {{in_array($answer,$question->right_answers)?'bg-success text-light':''}}">{{$answer}}</li>
                                    @endif
                                @endforeach
                            @else
                                <li class="list-group-item {{in_array($details[$question->id]['answer'],$question->right_answers)?'bg-success text-light':'text-light bg-danger'}}">
                                    {{$details[$question->id]['answer']}}
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('quizzes.reports.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
    </div>
@endsection
