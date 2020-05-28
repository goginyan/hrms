@extends('layouts.dashboard')

@section('title',__('My Quizzes'))

@section('content')
    <ul class="list-group list-group-flush quizzes-list">
        @forelse($quizzes as $quiz)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @unless($quiz->pivot->result)
                    <a href="{{route('quizzes.pass', $quiz)}}">
                        {{$quiz->title}}
                        @if ($quiz->author)
                            <span class="ml-3 badge badge-primary badge-lg">
                                {{__("Created By ")}} {{$quiz->author->fullName}}
                            </span>
                        @endif
                    </a>
                    <span data-toggle="tooltip" title="{{__('Active')}}"
                          class="badge badge-primary badge-lg">&nbsp;</span>
                @else
                    <span>
                        {{$quiz->title}}
                        @if ($quiz->author)
                            <span class="ml-3 badge badge-primary badge-lg">
                                {{__("Created By ")}} {{$quiz->author->fullName}}
                            </span>
                        @endif
                    </span>
                    <span data-toggle="tooltip" title="{{__('Done')}}" class="badge badge-success badge-lg">
                        {{$quiz->pivot->result}}%&nbsp;&nbsp;<i class="fas fa-check"></i>
                    </span>
                @endunless
            </li>
        @empty
            <p>{{__('There are not surveys attached to you')}}</p>
        @endforelse
    </ul>
@endsection