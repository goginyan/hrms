@extends('layouts.dashboard')

@section('title','Add Permission')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('threads.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="to">{{__('Message to')}}</label>
                            <select class="form-control custom-select" data-width="100%" name="to" id="to" required>
                                @foreach($employees as $employee)
                                    @continue($employee->id==Auth::user()->employee->id)
                                    <option value="{{$employee->user->id}}">{{$employee->fullName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">{{__('Message Subject')}}</label>
                            <input type="text" name="subject" id="subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="body">{{__('Message Text')}}</label>
                            <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <a href="{{route('threads.index')}}"
                               class="btn btn-outline-primary">{{__('Back To List')}}</a>
                            <button class="btn btn-primary">{{ __('Write') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
