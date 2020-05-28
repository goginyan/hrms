@extends('layouts.dashboard')

@section('title','Departments')

@section('content')
    <div class="list-group list-group-nested">
        @foreach($departments as $department)
            @include('department.tree', ['department' => $department])
        @endforeach
    </div>
    @can('create departments')
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('departments.create')}}" class="btn btn-primary">{{__('Add Department')}}</a>
        </div>
    @endcan
@endsection
