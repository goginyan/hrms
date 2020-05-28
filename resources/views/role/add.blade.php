@extends('layouts.dashboard')

@section('title','Add Role')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create roles')
                        <form action="{{route('roles.store')}}" method="post">
                            @csrf
                            @include('role.form')
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('roles.index')}}"
                                   class="btn btn-outline-primary">{{__('Back to List')}}</a>
                                <button class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
