@extends('layouts.dashboard')

@section('title','Quizzes')

@section('content')
    <ul class="list-group list-group-flush quizzes-list">
        @foreach($quizzes as $quiz)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{route('quizzes.show', $quiz)}}" class="d-flex align-items-center">
                    <span class="mr-2 badge {{$quiz->active?'badge-success':'badge-secondary'}}">&nbsp;</span>
                    <span>{{$quiz->title}}</span>
                    @if ($quiz->author)
                        <span
                            class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$quiz->author->fullName}}</span>
                    @endif
                </a>
                <form id="destroyQuiz{{$quiz->id}}"
                      action="{{route('quizzes.destroy', ['quiz'=>$quiz->id])}}"
                      method="post">
                    @csrf
                    @method('delete')
                </form>
                <button title="Delete Quiz" type="submit" form="destroyQuiz{{$quiz->id}}"
                        class="btn btn-sm btn-circle btn-danger destroy-btn">
                    <i class="fa fa-times"></i>
                </button>
            </li>
        @endforeach
    </ul>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <a href="{{route('quizzes.create')}}" class="btn btn-primary">{{__('Create Quiz')}}</a>
    </div>
@endsection