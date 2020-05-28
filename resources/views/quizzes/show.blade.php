@extends('layouts.dashboard')

@section('title', $quiz->title)

@section('content')
    <ul class="list-group list-group-flush quizzes-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Title')}}</span>
            <span class="badge badge-primary badge-lg">{{$quiz->title}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Description')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$quiz->description}}</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Employees')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($quiz->employees as $employee)
                    <span class="badge badge-primary badge-lg ml-3 mb-1">{{$employee->fullName}}</span>
                @endforeach
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Applicants')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($quiz->applicants as $applicant)
                    <span
                        class="badge badge-primary badge-lg ml-3 mb-1">{{$applicant->first_name??'No Name'}} {{$applicant->last_name??''}}
                        ({{$applicant->email}})</span>
                @endforeach
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Questions')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($quiz->questions as $question)
                    <span class="badge badge-primary badge-lg ml-3 mb-1">{{$question->title}}
                        &nbsp;<i>({{$questionTypes[$question->type]}})</i></span>
                @endforeach
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Active')}}</span>
            <span class="badge {{$quiz->active?"badge-success":"badge-secondary"}} badge-lg"><i
                    class="fas fa-check"></i></span>
        </li>
    </ul>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('quizzes.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        <button title="Delete Quiz" type="submit" form="destroyQuiz{{$quiz->id}}"
                class="btn btn-danger">
            {{__('Destroy Quiz')}}
        </button>
        <a href="{{route('quizzes.edit', $quiz)}}" class="btn btn-primary">{{__('Edit Quiz')}}</a>
    </div>
    <form id="destroyQuiz{{$quiz->id}}"
          action="{{route('quizzes.destroy', $quiz)}}"
          method="post">
        @csrf
        @method('delete')
    </form>
@endsection
