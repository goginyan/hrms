@extends('layouts.dashboard')

@section('title', __('Interview') . ' #' . $interview->id . ' (' . $interview->planned_at->format('d.m.Y H:i') . ')')

@section('content')
    <ul class="list-group list-group-flush interviews-list mt-2">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Status')}}:</span>
            <span class="badge badge-primary badge-lg">
                {{$statuses[$interview->status]}}
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('For vacancy')}}:</span>
            <span class="badge badge-primary badge-lg">
                {{$interview->vacancy->position}}
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Organizer')}}:</span>
            <span class="badge badge-primary badge-lg">{{$interview->organizer->fullName}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Candidate')}}:</span>
            <span class="badge badge-primary badge-lg">
                <a class="text-light"
                   href="{{route('applicants.show',$interview->applicant)}}">{{$interview->applicant->first_name??__("No Name")}} {{$interview->applicant->last_name??''}}</a>
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Members')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($interview->members as $member)
                    <span class="badge badge-primary badge-lg ml-2 mb-2">{{$member->fullName}}</span>
                @endforeach
            </span>
        </li>
        @if ($interview->comment)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Comment') }}</span>
                <span class="badge badge-primary badge-lg">{{$interview->comment}}</span>
            </li>
        @endif
    </ul>
    <div class="d-flex justify-content-between align-items-center mt-4">
        @can('manage interviews')
            <a href="{{route('interviews.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
            <form id="destroyInterview" class="d-none"
                  action="{{route('interviews.destroy', $interview)}}"
                  method="post">
                @csrf
                @method('delete')
            </form>
            <button type="submit" form="destroyInterview"
                    class="btn btn-danger">
                {{__('Cancel Interview')}}
            </button>
            <a href="{{route('interviews.edit', $interview)}}"
               class="btn btn-primary">{{__('Edit Interview')}}</a>
        @else
            <a href="{{route('dashboard')}}" class="btn btn-outline-primary">{{__('Back to Dashboard')}}</a>
        @endcan
    </div>
@endsection