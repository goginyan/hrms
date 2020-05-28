@extends('layouts.dashboard')

@section('title','Employees')

@section('content')
    @can('view employees')
        <ul class="list-group list-group-flush employees-list">
            @foreach($employees as $employee)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @can('view employee')
                        <a href="{{route('employees.show', ['employee'=>$employee->id])}}">
                            {{$employee->fullName}}
                            ({{$employee->email}}) - {{$employee->role}}
                        </a>
                    @else
                        <span>
                            {{$employee->fullName}} - {{$employee->role}}
                        </span>
                    @endcan
                    <span
                        class="badge badge-primary badge-lg">{{$employee->department?$employee->department->name:"..."}}</span>
                </li>
            @endforeach
        </ul>
    @endcan
    @can('create employees')
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('employees.create')}}" class="btn btn-primary">{{__('Add Employee')}}</a>
        </div>
    @endcan
@endsection
