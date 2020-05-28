@extends('layouts.dashboard')

@section('title',__('Notifications'))

@section('content')
    <ul class="list-group list-group-flush mt-3 notifications-list">
        @foreach($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center notification"
                data-id="{{$notification->id}}">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-{{$notification->data['color']}}">
                            <i class="{{$notification->data['icon']}} text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">
                            {{$notification->created_at->diffForHumans()}}
                        </div>
                        <a href="{{$notification->data['url']}}" class="{{$notification->read_at?:"font-weight-bold"}}">
                            {{$notification->data['text']}} · {{$notification->data['title']}}
                        </a>
                    </div>
                </div>
                <span class="badge mark-as-read badge-{{$notification->read_at?"light":"primary"}}"></span>
            </li>
        @endforeach
    </ul>
@endsection