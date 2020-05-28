@extends('layouts.dashboard')

@section('title','Add Employee')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create employees')
                        <form action="{{route('employees.store')}}" method="post">
                            @csrf
                            @include('employee.form',['departments'=>$departments, 'roles'=>$roles])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('employees.index')}}"
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
