@extends('layouts.dashboard')

@section('title','Add Team')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create teams')
                        <form action="{{route('teams.store')}}" method="post">
                            @csrf
                            @include('teams.form')
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('teams.index')}}"
                                   class="btn btn-outline-primary">{{__('Back To List')}}</a>
                                <button class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
