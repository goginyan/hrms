@extends('layouts.dashboard')

@section('title','Employees')

@section('content')
    <h4>{{$employee->fullName}}</h4>
    @can('view employee')
        <ul class="list-group list-group-flush employees-list mt-2">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Email:</span>
                <span class="badge badge-primary badge-lg">{{$employee->email}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Department:</span>
                <span class="badge badge-primary badge-lg">{{$employee->department->name}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Job Title:</span>
                <span class="badge badge-primary badge-lg">{{$employee->role}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Employment Status:</span>
                <span class="badge badge-primary badge-lg">{{__($employee->status)}}</span>
            </li>
            @if ($employee->manager)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Direct Manager:</span>
                    <span class="badge badge-primary badge-lg">{{__($employee->manager->fullName)}}</span>
                </li>
            @endif
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Time Off:</span>
                <span class="badge badge-primary badge-lg">{{$employee->paid_time}}/{{$employee->unpaid_time}}</span>
            </li>
        </ul>
    @endcan
    <div class="d-flex justify-content-between align-items-center mt-4">
        @can('view employees')
            <a href="{{route('employees.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        @endcan
        @can('delete employees')
            <form id="destroyEmployee" class="d-none"
                  action="{{route('employees.destroy', ['employee'=>$employee->id])}}"
                  method="post">
                @csrf
                @method('delete')
            </form>
            <button type="submit" form="destroyEmployee"
                    class="btn btn-danger">
                {{__('Remove Employee')}}
            </button>
        @endcan
        @can('update employees')
            <a href="{{route('employees.edit', ['employee'=>$employee->id])}}"
               class="btn btn-primary">{{__('Edit Employee')}}</a>
        @endcan
    </div>
@endsection
