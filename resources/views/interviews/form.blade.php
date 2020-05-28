<input type="hidden" name="vacancy_id" value="{{isset($interview)?$interview->vacancy->id:$vacancy->id}}">
<div class="form-group">
    <label for="planned_at"
           class="">{{ __('Planned At') }}</label>
    <input id="planned_at" type="text" data-type="datetime"
           class="form-control @error('planned_at') is-invalid @enderror"
           name="planned_at"
           value="{{ $interview->planned_at??'' }}" required>
    <span class="invalid-feedback" role="alert">
        {{$errors->first('planned_at')??''}}
    </span>
</div>
<div class="form-group">
    <label for="applicant_id">{{ __('Candidate') }}</label>
    <select name="applicant_id" data-placeholder="{{__('Select Candidate')}}"
            id="applicant_id" data-width="100%"
            class="form-control custom-select ">
        @foreach($candidates as $candidate)
            <option
                {{isset($interview)&&$interview->applicant->id==$candidate->id?"selected":""}} value="{{$candidate->id}}">{{$candidate->first_name??__('No Name')}} {{$candidate->last_name??__('No Surname')}}
                ({{$candidate->email??'No Email'}})
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('applicant_id')?"d-block":""}}">
        {{$errors->first('applicant_id')??""}}
    </div>
</div>
<div class="form-group">
    <div class="d-flex justify-content-between align-items-center">
        <label for="members">{{ __('Members') }}</label>
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
                        {{isset($interview)&&$interview->members->contains($employee->id)?"selected":""}} value="{{$employee->id}}">{{$employee->fullName}}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="comment"
           class="">{{ __('Comment') }}</label>
    <textarea id="comment" rows="5"
              class="form-control @error('comment') is-invalid @enderror"
              name="comment">{{ $interview->comment??'' }}</textarea>
    <span class="invalid-feedback" role="alert">
        <strong>{{$errors->first('comment')??''}}</strong>
    </span>
</div>