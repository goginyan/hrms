<div class="form-group">
    <label for="title">{{ __('Title') }}</label>
    <input type="text" id="title" name="title" class="form-control {{$errors->has('title')?"is-invalid":""}}"
           value="{{$task->title??""}}">
    <div class="invalid-feedback">
        {{$errors->first('title')??""}}
    </div>
</div>
<div class="form-group">
    <label for="parent">{{ __('Parent') }}</label>
    <select data-width="100%" name="parent_id" id="parent"
            class="form-control custom-select"
            data-placeholder="Select Parent Task">
        <option value="">{{__('Select Parent Task')}}</option>
        @foreach($tasks as $t)
            <option
                {{isset($task->parent) && $task->parent->id==$t->id ? "selected" : ""}} value="{{$t->id}}">{{$t->title}}</option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('parent_id')?"d-block":""}}">
        {{$errors->first('parent_id')??""}}
    </div>
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" cols="30" rows="5"
              class="form-control {{$errors->has('description')?"is-invalid":""}}">{{$task->description??""}}</textarea>
    <div class="invalid-feedback">
        {{$errors->first('description')??""}}
    </div>
</div>
<div class="form-group">
    <label for="assignee">{{ __('Assignee') }}</label>
    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-5">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" value="employee" id="toEmployee"
                               name="assign_type" {{isset($task) && $task->assignee->getMorphClass()=='team'?:"checked"}}>
                        <label class="custom-control-label" for="toEmployee">{{__('To Employee')}}</label>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <select data-width="100%" name="assignee_employee" id="assignee_employee"
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
        <div class="col-12 col-md-6 mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-5">
                    <div class="custom-control custom-radio">
                        <input type="radio"
                               {{isset($task) && $task->assignee->getMorphClass()=='team'?"checked":""}} class="custom-control-input"
                               value="team" id="toTeam" name="assign_type">
                        <label class="custom-control-label" for="toTeam">{{__('To Team')}}</label>
                    </div>
                </div>
                <div class="col-12 col-md-7">
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
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
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
                    <label class="custom-file-label" for="attachment1">{{__('Choose file')}}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
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
                    <label class="custom-file-label" for="attachment2">{{__('Choose file')}}</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="type">{{ __('Type') }}</label>
            <select data-width="100%" name="type" id="type"
                    class="form-control custom-select {{$errors->has('type')?"is-invalid":""}}"
                    data-placeholder="Select Task Type">
                @foreach($types as $key=>$value)
                    <option
                        {{isset($task->type) && $task->type==$key ? "selected" : ""}} value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{$errors->first('type')??""}}
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="priority">{{ __('Priority') }}</label>
            <select data-width="100%" name="priority" id="priority"
                    class="form-control custom-select {{$errors->has('priority')?"is-invalid":""}}"
                    data-placeholder="Select Task Type">
                @foreach($priorities as $key=>$value)
                    <option
                        {{isset($task->priority) && $task->priority==$key ? "selected" : ""}} value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{$errors->first('priority')??""}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="duration">{{ __('Duration (minutes)') }}</label>
            <input type="number" name="duration" min="0" step="30" id="duration" value=""
                   class="form-control {{$errors->has('duration')?"is-invalid":""}}">
            <div class="invalid-feedback">
                {{$errors->first('duration')??""}}
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="deadline">{{ __('Deadline') }}</label>
            <input data-type="datetime" placeholder="hh:mm dd.mm.yyyy" name="deadline" id="deadline" value=""
                   class="form-control {{$errors->has('deadline')?"is-invalid":""}}">
            <div class="invalid-feedback">
                {{$errors->first('deadline')??""}}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="responsible">{{ __('Responsible') }}</label>
    <select data-width="100%" name="responsible_id" id="responsible"
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
</div>