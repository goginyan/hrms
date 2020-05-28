@extends('layouts.dashboard')

@section('title',$tracker->title)

@section('content')
    <ul class="list-group list-group-flush trackers-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Start Date')}}</span>
            <span class="badge badge-primary badge-lg">{{$tracker->start_date->format('H:i d.m.Y')}}</span>
        </li>
        @if ($tracker->end_date)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{__('End Date')}}</span>
                <span class="badge badge-primary badge-lg">{{$tracker->end_date->format('H:i d.m.Y')}}</span>
            </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Location')}}</span>
            <span class="badge badge-primary badge-lg">{{$tracker->location}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Description')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$tracker->description}}</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Attachment')}}</span>
            <a href="{{$tracker->file}}" target="_blank">{{$tracker->file}}</a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Members')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($tracker->members as $member)
                    <span class="badge badge-primary badge-lg ml-3 mb-1">{{$member->fullName}}</span>
                @endforeach
            </span>
        </li>
    </ul>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('trackers.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        <button title="Delete Tracker" type="submit" form="destroyTracker{{$tracker->id}}"
                class="btn btn-danger">
            {{__('Destroy Tracker')}}
        </button>
        <button data-toggle="modal" data-target="#editTrackerModal"
                class="btn btn-info">{{__('Edit Tracker')}}</button>
    </div>
    <form id="destroyTracker{{$tracker->id}}"
          action="{{route('trackers.destroy', ['tracker'=>$tracker->id])}}"
          method="post">
        @csrf
        @method('delete')
    </form>

    <!-- Modal -->
    <div class="modal fade" id="editTrackerModal" role="dialog" aria-labelledby="editTrackerModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrackerModalLongTitle">{{__('Edit the Tracker')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{route('trackers.update',['tracker'=>$tracker->id])}}"
                      method="post" class="modal-body" id="editTrackerModalForm">
                    @csrf
                    @method('put')
                    @include('tracker.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="editTrackerModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="editTrackerModalForm" class="btn btn-primary">{{__('Update')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
