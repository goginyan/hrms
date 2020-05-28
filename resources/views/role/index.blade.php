@extends('layouts.dashboard')

@section('title','Roles')

@section('content')
    @can('view roles')
        <div class="list-group list-group-nested">
            @foreach($roles as $role)
                @continue($role->id==1)
                @include('role.tree', ['role' => $role])
            @endforeach
        </div>
    @endcan
    @can('create roles')
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('roles.create')}}" class="btn btn-primary">{{__('Add Role')}}</a>
        </div>
    @endcan
@endsection
