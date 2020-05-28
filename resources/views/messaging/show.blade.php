@extends('layouts.dashboard')

@section('title',\Illuminate\Support\Str::title($thread->subject))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex flex-column justify-content-start">
                @foreach($thread->messages as $msg)
                    <div
                        class="message-box mt-2 d-flex {{$msg->user->id==Auth::id()?"flex-row-reverse":""}} align-items-start">
                        <img data-toggle="tooltip" title="{{$msg->user->employee->fullName}}" width="40"
                             height="40" class="rounded-circle border-light"
                             src="{{$msg->user->employee->avatar??asset('images/no_avatar.jpg')}}"
                             alt="Avatar">
                        <p class="m-0 mx-3 msg-block {{$msg->user->id==Auth::id()?"text-light bg-primary":"text-primary bg-light"}}">{{$msg->body}}</p>
                        <small
                            class="text-secondary align-self-center">{{$msg->created_at->diffForHumans()}}</small>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex flex-column">
                <form id="replyForm" action="{{route('threads.update',['thread'=>$thread->id])}}"
                      method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="reply">{{__('Reply')}}</label>
                        <textarea class="form-control" name="reply" id="reply" rows="5" required></textarea>
                    </div>
                </form>
                <form id="destroy{{$thread->id}}"
                      action="{{route('threads.destroy', ['thread'=>$thread->id])}}"
                      method="post">
                    @csrf
                    @method('delete')
                </form>
                <div class="d-flex justify-content-between">
                    <a href="{{route('threads.index')}}" class="btn btn-outline-primary">{{__('All Threads')}}</a>
                    <button title="Remove" type="submit" form="destroy{{$thread->id}}"
                            class="btn btn-danger destroy-btn">{{__('Delete Thread')}}
                    </button>
                    <button form="replyForm" type="submit" class="btn btn-primary">{{__('Reply')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
