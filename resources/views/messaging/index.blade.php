@extends('layouts.dashboard')

@section('title',__('Threads'))

@section('content')
    <ul class="list-group list-group-flush threads-list">
        @foreach($threads as $thread)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{route('threads.show',$thread)}}">
                    @php($unreadCount = $thread->userUnreadMessagesCount(Auth::id()))
                    @if($unreadCount>0)
                        <span class="badge badge-danger">{{$unreadCount}}</span>
                    @endif
                    <span class="{{$thread->isUnread(Auth::id())>0?"font-weight-bold":""}}">
                        {{$thread->subject??__('Unnamed Thread')}}
                    </span>
                </a>
                <span class="badge badge-primary badge-lg">{{$thread->creator()->employee->fullName??""}}</span>
            </li>
        @endforeach
    </ul>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <a href="{{route('threads.create')}}" class="btn btn-primary">{{__("Write Message")}}</a>
    </div>
@endsection
