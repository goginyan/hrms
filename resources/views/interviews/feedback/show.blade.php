@extends('layouts.dashboard')

@section('title', __('Feedback of Interview') . ' #' . $interview->id . ' (' . $interview->planned_at->format('d.m.Y H:i') . ')')

@section('content')
    <div id="accordion">
        @foreach($members as $member)
            <div class="card">
                <div class="card-header" id="heading{{$member->id}}">
                    <h5 class="mb-0 d-flex justify-content-between align-items-center">
                        <a href="javascript:void(0);" class="btn-link" data-toggle="collapse"
                           data-target="#collapse{{$member->id}}"
                           aria-expanded="{{$loop->first?'true':'false'}}" aria-controls="collapse{{$member->id}}">
                            {{$member->fullName}} ({{$member->role}})
                        </a>
                        <span class="badge badge-primary badge-lg" data-toggle="tooltip" data-placement="left"
                              title="{{__('Rate')}}">
                            {{$member->pivot->feedback_rate}}
                        </span>
                    </h5>
                </div>
                <div id="collapse{{$member->id}}" class="collapse {{$loop->first?'show':''}}"
                     aria-labelledby="heading{{$member->id}}" data-parent="#accordion">
                    <div class="card-body">
                        {{$member->pivot->feedback_comment}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('interviews.index')}}" class="btn btn-outline-primary">{{__('All Interviews')}}</a>
        <a href="{{route('applicants.show', $interview->applicant)}}"
           class="btn btn-primary">{{__('View Applicant')}}</a>
    </div>
@endsection