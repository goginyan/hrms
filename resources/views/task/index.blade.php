@extends('layouts.dashboard')

@section('title',__('Tasks'))

@section('content')
    <table class="table table-bordered table-striped table-sm bg-light">
        <thead class="table-primary">
        <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('Parent')}}</th>
            <th>{{__('Title')}}</th>
            <th>{{__('Type')}}</th>
            <th>{{__('Status')}}</th>
            <th>{{__('Priority')}}</th>
            <th>{{__('Author')}}</th>
            <th>{{__('Assignee')}}</th>
            <th>{{__('Updated on')}}</th>
            <th>{{__('Responsible')}}</th>
        </tr>
        </thead>
        <tbody class="table-hover">
        @if($tasks->isEmpty())
            <tr>
                <td colspan="10" class="text-center">
                    {{__("You don't have any actual tasks yet")}}
                </td>
            </tr>
        @else
            @foreach($tasks as $task)
                <tr>
                    <td>
                        @can('update',$task)
                            <a href="{{route('tasks.edit',$task)}}">{{$task->id}}</a>
                        @else
                            <span>{{$task->id}}</span>
                        @endcan
                    </td>
                    <td>
                        @if ($task->parent)
                            @can('update',$task->parent)
                                <a href="{{route('tasks.edit',$task->parent)}}">{{$task->parent->title??""}}</a>
                            @else
                                <span>{{$task->parent->title??""}}</span>
                            @endcan
                        @endif
                    </td>
                    <td>{{$task->title}}</td>
                    <td>{{__($types[$task->type])}}</td>
                    <td>{{__($statuses[$task->status])}}</td>
                    <td>{{__($priorities[$task->priority])}}</td>
                    <td>{{$task->author->fullName}}</td>
                    <td>{{$task->assignee->getMorphClass()=='team' ? $task->assignee->name : $task->assignee->fullName}}</td>
                    <td>{{$task->updated_at->format('H:i d.m.Y')}}</td>
                    <td>{{$task->responsible->fullName??""}}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    @can('create', App\Models\Task::class)
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('tasks.create')}}" class="btn btn-primary">Add Task</a>
        </div>
    @endcan
@endsection
