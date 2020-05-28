<div class="row">
    <div class="form-group col-12 col-sm-6">
        <label for="position">{{ __('Position') }} *</label>
        <input value="{{$vacancy->position??""}}" type="text" id="position" placeholder="{{__('Job Position')}}"
               name="position"
               class="form-control {{$errors->has('position')?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first('position')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-6">
        <label for="location">{{ __('Location') }}</label>
        <select data-width="100%" class="form-control custom-select"
                name="location"
                id="location">
            <option value="">{{__('Select Location')}}</option>
            @foreach($countries as $country)
                @continue(!$country['capital'])
                <option
                    {{isset($vacancy) && $vacancy->location === "{$country['capital']}, {$country['name']['common']}"?"selected":""}} value="{{"{$country['capital']}, {$country['name']['common']}"}}">{{"{$country['capital']}, {$country['name']['common']}"}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback {{$errors->has('location')?"d-block":""}}">
            {{$errors->first('location')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-6">
        <label for="duration">{{ __('Duration') }}</label>
        <select data-width="100%" class="form-control custom-select"
                name="duration"
                id="duration">
            <option value="">{{__('Select Duration')}}</option>
            <option
                {{isset($vacancy)&&$vacancy->duration==='Long-Term'?'selected':''}} value="Long-Term">{{__('Long-Term')}}</option>
            <option
                {{isset($vacancy)&&$vacancy->duration==='Short-Term'?'selected':''}} value="Short-Term">{{__('Short-Term')}}</option>
        </select>
        <div class="invalid-feedback {{$errors->has('duration')?"d-block":""}}">
            {{$errors->first('duration')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-6">
        <label for="work_type">{{ __('Work Type') }}</label>
        <select data-width="100%" class="form-control custom-select"
                name="work_type"
                id="work_type">
            <option value="">{{__('Select Work Type')}}</option>
            <option
                {{isset($vacancy)&&$vacancy->work_type==='Full Time'?'selected':''}} value="Full Time">{{__('Full Time')}}</option>
            <option
                {{isset($vacancy)&&$vacancy->work_type==='Part Time'?'selected':''}} value="Part Time">{{__('Part Time')}}</option>
            <option
                {{isset($vacancy)&&$vacancy->work_type==='Remote'?'selected':''}} value="Remote">{{__('Remote')}}</option>
        </select>
        <div class="invalid-feedback {{$errors->has('work_type')?"d-block":""}}">
            {{$errors->first('work_type')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4">
        <label for="description">{{ __('Description') }}</label>
        <textarea class="form-control {{$errors->has('description')?"is-invalid":""}}"
                  name="description" rows="5"
                  id="description">{{$vacancy->description??""}}</textarea>
        <div class="invalid-feedback">
            {{$errors->first('description')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4">
        <label for="responsibilities">{{ __('Responsibilities') }}</label>
        <textarea class="form-control {{$errors->has('responsibilities')?"is-invalid":""}}"
                  name="responsibilities" rows="5"
                  id="responsibilities">{{$vacancy->responsibilities??""}}</textarea>
        <div class="invalid-feedback">
            {{$errors->first('responsibilities')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4">
        <label for="qualifications">{{ __('Qualifications') }}</label>
        <textarea class="form-control {{$errors->has('qualifications')?"is-invalid":""}}"
                  name="qualifications" rows="5"
                  id="qualifications">{{$vacancy->qualifications??""}}</textarea>
        <div class="invalid-feedback">
            {{$errors->first('qualifications')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4">
        <label for="open_date">{{ __('Open Date') }}</label>
        <input value="{{$vacancy->open_date??""}}" data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
               id="open_date" name="open_date"
               class="form-control {{$errors->has('open_date')?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first('open_date')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4">
        <label for="end_date">{{ __('End Date') }}</label>
        <input value="{{$vacancy->end_date??""}}" data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
               id="end_date"
               name="end_date"
               class="form-control {{$errors->has('end_date')?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first('end_date')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4">
        <label for="application_procedure">{{ __('Application Procedure') }}</label>
        <input value="{{$vacancy->application_procedure??""}}" type="text" id="application_procedure"
               name="application_procedure"
               class="form-control {{$errors->has('application_procedure')?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first('application_procedure')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-3">
        <label for="contact_person_id">{{ __('Contact Person') }}</label>
        <select data-width="100%" class="form-control custom-select"
                name="contact_person_id"
                id="contact_person_id">
            <option value="">{{__('Select Contact Person')}}</option>
            @foreach($employees as $employee)
                <option
                    {{isset($vacancy->contactPerson) && $vacancy->contactPerson->id == $employee->id ?"selected":""}} value="{{$employee->id}}">{{$employee->fullName}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback {{$errors->has('contact_person_id')?"d-block":""}}">
            {{$errors->first('contact_person_id')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-3">
        <label for="salary">{{ __('Salary') }}</label>
        <input value="{{$vacancy->salary??""}}" type="number" id="salary" name="salary"
               class="form-control {{$errors->has('salary')?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first('salary')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-3">
        <label for="salary_currency">{{ __('Salary Currency') }}</label>
        <select data-width="100%" class="form-control custom-select"
                name="salary_currency"
                id="salary_currency">
            <option value="">{{__('Select Currency')}}</option>
            @foreach($currencies as $currency=>$name)
                <option
                    {{isset($vacancy) && $vacancy->salary_currency == $currency?"selected":""}} value="{{$currency}}">{{$currency}}
                    ({{$name}})
                </option>
            @endforeach
        </select>
        <div class="invalid-feedback {{$errors->has('salary_currency')?"d-block":""}}">
            {{$errors->first('salary_currency')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-3">
        <label for="contact_email">{{ __('Contact Email') }}</label>
        <input value="{{$vacancy->contact_email??""}}" type="email" id="contact_email" name="contact_email"
               class="form-control {{$errors->has('contact_email')?"is-invalid":""}}">
        <div class="invalid-feedback">
            {{$errors->first('contact_email')??""}}
        </div>
    </div>
    <div class="form-group col-auto mx-auto">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input"
                   {{isset($vacancy)&&$vacancy->with_form?"checked":""}} id="with_form" value="1" name="with_form">
            <label class="custom-control-label" for="with_form" data-toggle="collapse" data-target="#collapseForm"
                   aria-expanded="{{isset($vacancy)&&$vacancy->with_form?"true":"false"}}"
                   aria-controls="collapseForm">{{ __('With Application Form') }}</label>
        </div>
    </div>
</div>
<div class="row collapse {{isset($vacancy)&&$vacancy->with_form?"show":""}}"
     aria-expanded="{{isset($vacancy)&&$vacancy->with_form?"true":"false"}}" id="collapseForm">
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="first_name">{{ __('First Name') }}</label>
        <select name="first_name" id="first_name" class="form-control {{$errors->has('first_name')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->first_name==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('first_name')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="last_name">{{ __('Last Name') }}</label>
        <select name="last_name" id="last_name" class="form-control {{$errors->has('last_name')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->last_name==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('last_name')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="patronymic">{{ __('Patronymic') }}</label>
        <select name="patronymic" id="patronymic" class="form-control {{$errors->has('patronymic')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->patronymic==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('patronymic')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="photo">{{ __('Photo') }}</label>
        <select name="photo" id="photo" class="form-control {{$errors->has('photo')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->photo==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('photo')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="sex">{{ __('Sex') }}</label>
        <select name="sex" id="sex" class="form-control {{$errors->has('sex')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option {{isset($vacancy)&&$vacancy->sex==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('sex')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="family_status">{{ __('Family Status') }}</label>
        <select name="family_status" id="family_status"
                class="form-control {{$errors->has('family_status')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->family_status==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('family_status')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="nationality">{{ __('Nationality') }}</label>
        <select name="nationality" id="nationality"
                class="form-control {{$errors->has('nationality')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->nationality==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('nationality')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="phone">{{ __('Phone') }}</label>
        <select name="phone" id="phone" class="form-control {{$errors->has('phone')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->phone==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('phone')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="address">{{ __('Address') }}</label>
        <select name="address" id="address" class="form-control {{$errors->has('address')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->address==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('address')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="email">{{ __('Email') }}</label>
        <select name="email" id="email" class="form-control {{$errors->has('email')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->email==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('email')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="education">{{ __('Education') }}</label>
        <select name="education" id="education" class="form-control {{$errors->has('education')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->education==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('education')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="work_experience">{{ __('Work Experience') }}</label>
        <select name="work_experience" id="work_experience"
                class="form-control {{$errors->has('work_experience')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->work_experience==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('work_experience')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="achievements">{{ __('Achievements') }}</label>
        <select name="achievements" id="achievements"
                class="form-control {{$errors->has('achievements')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->achievements==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('achievements')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="certificates">{{ __('Certificates') }}</label>
        <select name="certificates" id="certificates"
                class="form-control {{$errors->has('certificates')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->certificates==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('certificates')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="skills">{{ __('Skills') }}</label>
        <select name="skills" id="skills" class="form-control {{$errors->has('skills')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->skills==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('skills')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="languages">{{ __('Languages') }}</label>
        <select name="languages" id="languages" class="form-control {{$errors->has('languages')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->languages==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('languages')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="interests">{{ __('Interests') }}</label>
        <select name="interests" id="interests" class="form-control {{$errors->has('interests')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->interests==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('interests')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="attach_cv">{{ __('Attach CV') }}</label>
        <select name="attach_cv" id="attach_cv" class="form-control {{$errors->has('attach_cv')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->attach_cv==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('attach_cv')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="cover_letter">{{ __('Attach Cover Letter') }}</label>
        <select name="cover_letter" id="cover_letter"
                class="form-control {{$errors->has('cover_letter')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->cover_letter==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('cover_letter')??""}}
        </div>
    </div>
    <div class="form-group col-12 col-sm-4 col-md-2">
        <label for="linked_in">{{ __('LinkedIn Profile') }}</label>
        <select name="linked_in" id="linked_in" class="form-control {{$errors->has('linked_in')?"is-invalid":""}}">
            <option value="">{{__('Hidden')}}</option>
            @foreach ($statuses as $key=>$value)
                <option
                    {{isset($vacancy)&&$vacancy->linked_in==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{$errors->first('linked_in')??""}}
        </div>
    </div>
</div>