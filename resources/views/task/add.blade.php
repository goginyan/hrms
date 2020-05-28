@extends('layouts.dashboard')

@section('title',__('Add Task'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create', App\Models\Task::class)
                        <form action="{{route('tasks.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('task.form',['tasks'=>$tasks])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('tasks.index')}}"
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
