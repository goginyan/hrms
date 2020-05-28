@extends('layouts.dashboard')

@section('title',$event->title)

@section('content')
    <ul class="list-group list-group-flush events-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Start Date')}}</span>
            <span class="badge badge-primary badge-lg">{{$event->start_date->format('H:i d.m.Y')}}</span>
        </li>
        @if ($event->end_date)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{__('End Date')}}</span>
                <span class="badge badge-primary badge-lg">{{$event->end_date->format('H:i d.m.Y')}}</span>
            </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Location')}}</span>
            <span class="badge badge-primary badge-lg">{{$event->location}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Description')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$event->description}}</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Attachment')}}</span>
            <a href="{{$event->file}}" target="_blank">{{$event->file}}</a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Members')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($event->members as $member)
                    <span class="badge badge-primary badge-lg ml-2 mb-2">{{$member->fullName}}</span>
                @endforeach
            </span>
        </li>
    </ul>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('events.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        @can('delete', $event)
            <button title="Delete Event" type="submit" form="destroyEvent{{$event->id}}"
                    class="btn btn-danger">
                {{__('Destroy Event')}}
            </button>
        @endcan
        @can('update', $event)
            <button data-toggle="modal" data-target="#editEventModal"
                    class="btn btn-primary">{{__('Edit Event')}}</button>
        @endcan
    </div>
    <form id="destroyEvent{{$event->id}}"
          action="{{route('events.destroy', ['event'=>$event->id])}}"
          method="post">
        @csrf
        @method('delete')
    </form>

    @can('update', $event)
        <!-- Modal -->
        <div class="modal fade" id="editEventModal" role="dialog" aria-labelledby="editEventModalTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEventModalLongTitle">{{__('Edit the Event')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" action="{{route('events.update',['event'=>$event->id])}}"
                          method="post" class="modal-body" id="editEventModalForm">
                        @csrf
                        @method('put')
                        @include('event.form')
                    </form>
                    <div class="modal-footer">
                        <button type="reset" form="editEventModalForm" class="btn btn-outline-primary"
                                data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" form="editEventModalForm"
                                class="btn btn-primary">{{__('Update')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
