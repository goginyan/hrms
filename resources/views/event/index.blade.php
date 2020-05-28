@extends('layouts.dashboard')

@section('title','Events')

@section('content')
    @if (!empty($errors))
        <div class="d-flex flex-column justify-content-end align-items-center">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    {{__($error)}}
                    <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        </div>
    @endif
    <ul class="list-group list-group-flush events-list">
        @foreach($events as $event)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @can('view', $event)
                    <a href="{{route('events.show', ['event'=>$event->id])}}">
                        {{$event->title}}
                        @if ($event->creator)
                            <span
                                class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$event->creator->fullName}}</span>
                        @endif
                    </a>
                @else
                    <span>
                        {{$event->title}}
                        @if ($event->creator)
                            <span
                                class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$event->creator->fullName}}</span>
                        @endif
                    </span>
                @endcan
                @can('delete',$event)
                    <form id="destroyEvent{{$event->id}}"
                          action="{{route('events.destroy', ['event'=>$event->id])}}"
                          method="post">
                        @csrf
                        @method('delete')
                    </form>
                    <button title="Delete Event" type="submit" form="destroyEvent{{$event->id}}"
                            class="btn btn-sm btn-circle btn-danger destroy-btn">
                        <i class="fa fa-times"></i>
                    </button>
                @endcan
            </li>
        @endforeach
        @unset($event)
    </ul>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <button data-toggle="modal" data-target="#createEventModal"
                class="btn btn-primary">{{__('Add Event')}}</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createEventModal" role="dialog" aria-labelledby="createEventModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLongTitle">{{__('Create new Event')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{route('events.store')}}" method="post" class="modal-body"
                      id="createEventModalForm">
                    @csrf
                    @include('event.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="createEventModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="createEventModalForm" class="btn btn-primary">{{__('Create')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection