@extends('layouts.dashboard')

@section('title',__('Task Details'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            @can('update', $task)
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 d-flex justify-content-between align-items-center">
                            <span>
                                {{$task->title}}
                                <span title="{{__('Task author')}}"
                                      class="badge badge-secondary badge-lg ml-2">by {{$task->author->fullName}}</span>
                            </span>
                            <span class="d-flex justify-content-end align-items-center">
                                <span title="{{__('Task type')}}"
                                      class="badge badge-primary badge-lg mr-3">{{__($types[$task->type])}}</span>
                                <span title="{{__('Task priority')}}"
                                      class="badge badge-info badge-lg mr-3">{{__($priorities[$task->priority])}}</span>
                                <span title="{{__('Task status')}}"
                                      class="badge badge-success badge-lg">{{__($statuses[$task->status])}}</span>
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('tasks.update',['task'=>$task->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea name="description" id="description" cols="30" rows="5"
                                          class="form-control">{{$task->description??""}}</textarea>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label for="parent" class="m-0">{{ __('Parent') }}</label>
                                    <select data-width="50%" name="parent_id" id="parent"
                                            class="form-control custom-select {{$errors->has('parent')?"is-invalid":""}}"
                                            data-placeholder="Select Parent Task">
                                        <option value="">{{__('Select Parent Task')}}</option>
                                        @foreach($tasks as $t)
                                            <option
                                                {{isset($task->parent) && $task->parent->id==$t->id ? "selected" : ""}} value="{{$t->id}}">{{$t->title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first('parent_id')??""}}
                                    </div>
                                </li>
                                <li class="list-group-item align-items-center">
                                    <label for="assignee">{{ __('Assignee') }}</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                               value="employee"
                                                               id="toEmployee"
                                                               name="assign_type" {{isset($task) && $task->assignee->getMorphClass()=='team'?:"checked"}}>
                                                        <label class="custom-control-label"
                                                               for="toEmployee">{{__('To Employee')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <select data-width="100%" name="assignee_employee"
                                                            id="assignee_employee"
                                                            class="form-control custom-select"
                                                            data-placeholder="Select Assignee of the Task">
                                                        @foreach($employees as $e)
                                                            <option
                                                                {{isset($task->assignee) && $task->assignee->id==$e->id ? "selected" : ""}} value="{{$e->id}}">{{$e->fullName}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio"
                                                               {{isset($task) && $task->assignee->getMorphClass()=='team'?"checked":""}} class="custom-control-input"
                                                               value="team" id="toTeam" name="assign_type">
                                                        <label class="custom-control-label"
                                                               for="toTeam">{{__('To Team')}}</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <select data-width="100%" name="assignee_team" id="assignee_team"
                                                            class="form-control custom-select"
                                                            data-placeholder="Select Assignee of the Task">
                                                        @foreach($teams as $t)
                                                            <option
                                                                {{isset($task) && $task->assignee->id==$t->id ? "selected" : ""}} value="{{$t->id}}">{{$t->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label for="duration" class="m-0">{{ __('Duration (minutes)') }}</label>
                                    <input type="number" name="duration" min="0" step="30" id="duration"
                                           value="{{$task->duration??""}}"
                                           class="form-control w-50 {{$errors->has('duration')?"is-invalid":""}}">
                                    <div class="invalid-feedback">
                                        {{$errors->first('duration')??""}}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label for="deadline" class="m-0">{{ __('Deadline') }}</label>
                                    <input data-type="datetime" name="deadline" id="deadline"
                                           value="{{$task->deadline}}"
                                           {{$task->deadline?"readonly":""}}
                                           class="form-control w-50 {{$errors->has('deadline')?"is-invalid":""}}">
                                    <div class="invalid-feedback">
                                        {{$errors->first('deadline')??""}}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label for="responsible" class="m-0">{{ __('Responsible') }}</label>
                                    <select data-width="50%" name="responsible_id" id="responsible"
                                            class="form-control custom-select {{$errors->has('responsible_id')?"is-invalid":""}}"
                                            data-placeholder="Select Responsible for the Task">
                                        @foreach($employees as $e)
                                            <option
                                                {{isset($task->responsible) && $task->responsible->id==$e->id ? "selected" : ""}} value="{{$e->id}}">{{$e->fullName}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first('responsible_id')??""}}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label for="status" class="m-0">{{ __('Status') }}</label>
                                    <select data-width="50%" name="status" id="status"
                                            class="form-control custom-select {{$errors->has('status')?"is-invalid":""}}"
                                            data-placeholder="Select Task Status">
                                        @foreach($statuses as $key=>$value)
                                            <option
                                                {{isset($task->status) && $task->status==$key ? "selected" : ""}} value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first('status')??""}}
                                    </div>
                                </li>
                                @if(Auth::id() == $task->author->user->id)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <label for="priority" class="m-0">{{ __('Priority') }}</label>
                                        <select data-width="50%" name="priority" id="priority"
                                                class="form-control custom-select {{$errors->has('priority')?"is-invalid":""}}"
                                                data-placeholder="Select Task Priority">
                                            @foreach($priorities as $key=>$value)
                                                <option
                                                    {{isset($task->priority) && $task->priority==$key ? "selected" : ""}} value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{$errors->first('priority')??""}}
                                        </div>
                                    </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a class="w-50" href="{{$task->attachments[0]??"#"}}">
                                        @isset ($task->attachments[0])
                                            <img class="w-50"
                                                 src="{{$task->attachments[0]??""}}"
                                                 alt="Image">
                                        @endisset
                                    </a>
                                    <div class="form-group w-50">
                                        <label for="attachment1">{{ __('Attach Image') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input {{$errors->has('attachments.1')?"is-invalid":""}}"
                                                       id="attachment1"
                                                       name="attachments[]">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('attachments.1')??""}}
                                                </div>
                                                <label class="custom-file-label"
                                                       for="attachment1">{{__('Choose file')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a class="w-50" href="{{$task->attachments[1]??"#"}}">
                                        @isset ($task->attachments[1])
                                            <img class="w-50"
                                                 src="{{$task->attachments[1]??""}}"
                                                 alt="Image">
                                        @endisset
                                    </a>
                                    <div class="form-group w-50">
                                        <label for="attachment2">{{ __('Attach Another Image') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input {{$errors->has('attachments.2')?"is-invalid":""}}"
                                                       id="attachment2"
                                                       name="attachments[]">
                                                <div class="invalid-feedback">
                                                    {{$errors->first('attachments.2')??""}}
                                                </div>
                                                <label class="custom-file-label"
                                                       for="attachment2">{{__('Choose file')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="form-group d-flex justify-content-between align-items-center mt-5">
                                <a href="{{route('tasks.index')}}"
                                   class="btn btn-outline-primary">{{__('Back to List')}}</a>
                                <button class="btn btn-primary">{{__('Update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection