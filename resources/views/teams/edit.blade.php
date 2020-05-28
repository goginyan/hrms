@extends('layouts.dashboard')

@section('title','Edit Team')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('update',$team)
                        <form action="{{route('teams.update',['team'=>$team->id])}}" method="post">
                            @csrf
                            @method('put')
                            @include('teams.form',['team'=>$team])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('teams.show',$team)}}"
                                   class="btn btn-outline-primary">{{__('Back')}}</a>
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
