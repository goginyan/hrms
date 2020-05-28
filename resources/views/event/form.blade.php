<div class="form-group">
    <label for="title">{{__('Title')}} *</label>
    <input type="text" required name="title" id="title" value="{{$event->title??""}}" class="form-control">
</div>
<div class="form-group">
    <label for="start_date">{{__('Start Date')}} *</label>
    <input data-type="datetime" autocomplete="off" value="{{$event->start_date??""}}" placeholder="hh:mm dd.mm.yyyy"
           required name="start_date" id="start_date" class="form-control">
</div>
<div class="form-group">
    <label for="end_date">{{__('End Date')}}</label>
    <input data-type="datetime" autocomplete="off" value="{{$event->end_date??""}}" placeholder="hh:mm dd.mm.yyyy"
           name="end_date" id="end_date" class="form-control">
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea class="form-control"
              name="description" rows="5"
              id="description">{{$event->description??""}}</textarea>
</div>
<div class="form-group">
    <label for="location">{{ __('Location') }} *</label>
    <select data-width="100%" class="form-control custom-select"
            name="location" required
            id="location">
        <option value="">{{__('Select Location')}}</option>
        @foreach($countries as $country)
            @continue(!$country['capital'])
            <option
                {{isset($event) && $event->location === "{$country['capital']}, {$country['name']['common']}"?"selected":""}} value="{{"{$country['capital']}, {$country['name']['common']}"}}">{{"{$country['capital']}, {$country['name']['common']}"}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <div class="d-flex justify-content-between align-items-center">
        <label for="members">{{ __('Members') }} *</label>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select-all"
                   id="membersSelectAll">
            <label class="custom-control-label" for="membersSelectAll">{{__('Select All')}}</label>
        </div>
    </div>
    <select data-width="100%" class="form-control custom-select"
            name="members[]" required multiple
            id="members">
        @foreach($departments as $department)
            <optgroup class="select2-result-selectable" label="{{$department->name}}">
                @foreach($department->employees as $employee)
                    <option
                        {{isset($event)&&$event->members->contains($employee->id)?"selected":""}} value="{{$employee->id}}">{{$employee->fullName}}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="file">{{__('Attachment')}}</label>
    <div class="custom-file">
        <input name="file" type="file"
               class="custom-file-input" id="file">
        <label class="custom-file-label" for="file">{{__('Choose a file')}}</label>
    </div>
</div>
<div class="custom-control custom-checkbox">
    <input name="reminder" type="checkbox" {{isset($event)&&$event->reminder?"checked":""}} value="1"
           class="custom-control-input"
           id="reminder">
    <label class="custom-control-label" for="reminder">{{__('Reminder')}}</label>
</div>