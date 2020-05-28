@extends('layouts.dashboard')

@section('title', $quiz->title)

@section('content')
    <ul class="list-group list-group-flush quizables-list">
        @forelse($quizables as $quizable)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @if ($quizable->pivot->result)
                    <a href="{{route('quizzes.reports.show.quizable',[$quiz,$scope,$quizable])}}">
                        {{$quizable->first_name??'No Name'}} {{$quizable->last_name??''}}
                        ({{$quizable->email}})
                    </a>
                @else
                    <span>
                        {{$quizable->first_name??'No Name'}} {{$quizable->last_name??''}}
                        ({{$quizable->email}})
                    </span>
                @endif
                <span class="badge {{$quizable->pivot->result?'badge-success':'badge-secondary'}} badge-lg">
                    {{$quizable->pivot->result??0}}%
                </span>
            </li>
        @empty
            <li class="list-group-item d-flex justify-content-center align-items-center">
                <span>{{__('There are no '.$scope.' attached to the quiz')}}</span>
            </li>
        @endforelse
    </ul>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('quizzes.reports.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        <a href="{{route('quizzes.reports.show', [$quiz,'scope'=> $alterScope])}}"
           class="btn btn-primary">{{__('Switch to '.\Illuminate\Support\Str::title($alterScope))}}</a>
    </div>
@endsection
