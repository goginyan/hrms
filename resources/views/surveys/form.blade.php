<div class="form-group">
    <label for="title">{{__('Title')}} *</label>
    <input type="text" required name="title" id="title" value="{{$survey->title??""}}" class="form-control">
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea class="form-control"
              name="description" rows="5"
              id="description">{{$survey->description??""}}</textarea>
</div>
<div class="form-group">
    <div class="d-flex justify-content-between align-items-center">
        <label for="employees">{{ __('Attach to') }}</label>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select-all"
                   id="employeesSelectAll">
            <label class="custom-control-label" for="employeesSelectAll">{{__('Select All')}}</label>
        </div>
    </div>
    <select data-width="100%" class="form-control custom-select"
            name="employees[]" required multiple
            id="employees">
        @foreach($departments as $department)
            <optgroup class="select2-result-selectable" label="{{$department->name}}">
                @foreach($department->employees as $employee)
                    <option
                        {{isset($survey)&&$survey->employees->contains($employee->id)?"selected":""}} value="{{$employee->id}}">{{$employee->fullName}}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="expired_at">{{__('Expire Date')}}</label>
    <input data-type="date" autocomplete="off" value="{{$survey->expired_at??""}}" placeholder="dd.mm.yyyy"
           name="expired_at" id="expired_at" class="form-control">
</div>
<div class="custom-control custom-checkbox">
    <input name="active" type="checkbox" {{isset($survey) && $survey->active?"checked":""}} value="1"
           class="custom-control-input"
           id="active">
    <label class="custom-control-label" for="active">{{__('Active')}}</label>
</div>