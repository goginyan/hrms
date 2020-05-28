@extends('layouts.dashboard')

@section('title','Edit Department')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('update departments')
                        <form action="{{route('departments.update',['department'=>$department->id])}}" method="post">
                            @csrf
                            @method('put')
                            @include('department.form',["department"=>$department,"departments"=>$departments])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('departments.index')}}"
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
