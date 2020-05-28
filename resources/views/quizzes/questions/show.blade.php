@extends('layouts.dashboard')

@section('title',$question->title)

@section('content')
    <ul class="list-group list-group-flush question-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Question')}}</span>
            <span class="badge badge-primary badge-lg">{{$question->text}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Type')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$types[$question->type]}}</span>
            </div>
        </li>
        @if ($question->type !== 'text')
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{__('Possible Answers')}}</span>
                <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                    @foreach($question->answers as $answer)
                        <span class="badge badge-primary badge-lg ml-3 mb-1">{{$answer}}</span>
                    @endforeach
                </span>
            </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Right Answer(s)')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($question->right_answers as $answer)
                    <span class="badge badge-primary badge-lg ml-3 mb-1">{{$answer}}</span>
                @endforeach
            </span>
        </li>
    </ul>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('quiz.questions.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        <button type="submit" form="destroyQuestion{{$question->id}}"
                class="btn btn-danger">
            {{__('Remove Question')}}
        </button>
        <a href="{{route('quiz.questions.edit',$question)}}" class="btn btn-primary">{{__('Edit Question')}}</a>
    </div>
    <form id="destroyQuestion{{$question->id}}"
          action="{{route('quiz.questions.destroy', $question)}}"
          method="post">
        @csrf
        @method('delete')
    </form>
@endsection
