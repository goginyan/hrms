@extends('layouts.dashboard')

@section('title','Edit Employee')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('update employees')
                        <form id="employeeForm" action="{{route('employees.update',['employee'=>$employee->id])}}"
                              method="post">
                            @csrf
                            @method('put')
                            @include('employee.form',['departments'=>$departments, 'roles'=>$roles, 'employee'=>$employee])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('employees.index')}}"
                                   class="btn btn-outline-primary">{{__('Back to List')}}</a>
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
