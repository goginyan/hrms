@extends('layouts.dashboard')

@section('title',__('My Surveys'))

@section('content')
    <ul class="list-group list-group-flush surveys-list">
        @forelse($surveys as $survey)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @switch($survey->pivot->status)
                    @case('active')
                    <a href="{{route('surveys.pass', $survey)}}">
                        {{$survey->title}}
                        @if ($survey->author)
                            <span
                                class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$survey->author->fullName}}</span>
                        @endif
                    </a>
                    <span data-toggle="tooltip" title="{{__('Active')}}"
                          class="badge badge-primary badge-lg">&nbsp;</span>
                    @break
                    @case('expired')
                    <span>
                        {{$survey->title}}
                        @if ($survey->author)
                            <span
                                class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$survey->author->fullName}}</span>
                        @endif
                    </span>
                    <span data-toggle="tooltip" title="{{__('Expired')}}"
                          class="badge badge-danger badge-lg">&nbsp;</span>
                    @break
                    @default
                    <span>
                        {{$survey->title}}
                        @if ($survey->author)
                            <span
                                class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$survey->author->fullName}}</span>
                        @endif
                    </span>
                    <span data-toggle="tooltip" title="{{__('Done')}}" class="badge badge-success badge-lg"><i
                            class="fas fa-check"></i></span>
                    @break
                @endswitch
            </li>
        @empty
            <p>{{__('There are not surveys attached to you')}}</p>
        @endforelse
    </ul>
@endsection