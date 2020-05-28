<div class="form-group">
    <label for="task">{{ __('Task') }}</label>
    <select data-width="100%" class="form-control custom-select"
            name="task_id" {{$fields['task']??"required"}}
            id="task">
        <option value="">{{__('Select Task')}}</option>
        @foreach($tasks as $task)
            <option value="{{$task->id}}">{{$task->title}}</option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('task_id')?"d-block":""}}">
        {{$errors->first('task_id')??""}}
    </div>
</div>
<div class="form-group">
    <label for="comment">{{ __('Comment') }}</label>
    <textarea class="form-control" {{$fields['comment']??""}}
    name="comment" rows="5"
              id="comment"></textarea>
</div>
@if(isset($fields['date']))
    <div class="form-group">
        <label for="date">{{ __('Date') }}</label>
        <input data-type="datetime" class="form-control bg-light" {{$fields['date']}}
        name="created_at" id="date" value="">
    </div>
@endif
@if(isset($fields['duration']))
    <div class="form-group">
        <label for="duration">{{ __('Duration (minutes)') }}</label>
        <input type="number" class="form-control" {{$fields['duration']}}
        name="duration" id="duration" value="">
    </div>
@endif