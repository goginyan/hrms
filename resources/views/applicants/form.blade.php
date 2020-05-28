<div class="form-group">
    <label for="first_name"
           class="">{{ __('First Name') }}</label>
    <input id="first_name" type="text"
           class="form-control @error('first_name') is-invalid @enderror"
           name="first_name"
           value="{{ $applicant->first_name??'' }}" required>
    <span class="invalid-feedback" role="alert">
        {{$errors->first('first_name')??''}}
    </span>
</div>
<div class="form-group">
    <label for="last_name">{{ __('Last Name') }}</label>
    <input id="last_name" type="text"
           class="form-control @error('last_name') is-invalid @enderror"
           name="last_name"
           value="{{ $applicant->last_name??'' }}" required>
    <span class="invalid-feedback" role="alert">
        {{$errors->first('last_name')??''}}
    </span>
</div>
<div class="form-group">
    <label for="email"
           class="">{{ __('Email') }}</label>
    <input id="email" type="email"
           class="form-control @error('email') is-invalid @enderror"
           name="email"
           value="{{ $applicant->email??'' }}" required>
    <span class="invalid-feedback" role="alert">
        <strong>{{$errors->first('email')??''}}</strong>
    </span>
</div>
@if ($vacancy->patronymic)
    <div class="form-group">
        <label for="patronymic"
               class="">{{ __('Patronymic') }}</label>
        <input id="patronymic" type="text"
               class="form-control @error('patronymic') is-invalid @enderror"
               name="patronymic"
               value="{{ $applicant->patronymic??'' }}" {{$vacancy->patronymic}}>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('patronymic')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->photo)
    <div class="form-group">
        <label for="photo"
               class="">{{ __('Photo') }}</label>
        <div class="custom-file">
            <input {{$vacancy->photo}} name="photo" type="file"
                   class="custom-file-input @error('photo') is-invalid @enderror"
                   id="photo">
            <label class="custom-file-label"
                   for="photo">{{$applicant->photo ?? __('Choose a file')}}</label>
        </div>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('photo')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->sex)
    <div class="form-group">
        <label for="sex"
               class="">{{ __('Sex') }}</label>
        <select {{$vacancy->sex}} name="sex" id="sex"
                class="form-control @error('patronymic') is-invalid @enderror">
            @foreach ($sexes as $key=>$value)
                <option value="{{$key}}"
                    {{isset($applicant) && $applicant->sex===$key?'selected':''}}>{{__($value)}}</option>
            @endforeach
        </select>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('sex')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->family_status)
    <div class="form-group">
        <label for="family_status"
               class="">{{ __('Family Status') }}</label>
        <input id="family_status" type="text"
               class="form-control @error('family_status') is-invalid @enderror"
               name="family_status"
               value="{{ $applicant->family_status??'' }}" {{$vacancy->family_status}}>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('family_status')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->nationality)
    <div class="form-group">
        <label for="nationality"
               class="">{{ __('Nationality') }}</label>
        <select {{$vacancy->nationality}} data-width="100%" name="nationality"
                id="nationality"
                class="form-control custom-select @error('patronymic') is-invalid @enderror">
            @foreach ($countries as $country)
                @continue(!$country['demonym'])
                <option
                    value="{{$country['demonym']}}" {{isset($applicant) && $applicant->nationality===$country['demonym']?'selected':''}}>{{$country['demonym']}}</option>
            @endforeach
        </select>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('nationality')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->phone)
    <div class="form-group">
        <label for="phone"
               class="">{{ __('Phone') }}</label>
        <input data-target="phone" type="tel"
               class="form-control iti-input @error('phone') is-invalid @enderror"
               value="{{ $applicant->phone??'' }}" {{$vacancy->phone}}>
        <input type="hidden" id="phone"
               name="phone"
               value="{{ $applicant->phone??'' }}">
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('phone')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->address)
    <div class="form-group">
        <label for="address"
               class="">{{ __('Address') }}</label>
        <input id="address" type="text"
               class="form-control @error('address') is-invalid @enderror"
               name="address"
               value="{{ $applicant->address??'' }}" {{$vacancy->address}}>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('address')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->education)
    <div class="form-group">
        <label for="education"
               class="">{{ __('Education') }}</label>
        <textarea {{$vacancy->education}} id="education" rows="5"
                  class="form-control @error('education') is-invalid @enderror"
                  name="education">{{ $applicant->education??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('education')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->work_experience)
    <div class="form-group">
        <label for="work_experience"
               class="">{{ __('Work Experience') }}</label>
        <textarea {{$vacancy->work_experience}} id="work_experience" rows="5"
                  class="form-control @error('work_experience') is-invalid @enderror"
                  name="work_experience">{{ $applicant->work_experience??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('work_experience')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->achievements)
    <div class="form-group">
        <label for="achievements">{{ __('Achievements') }}</label>
        <textarea {{$vacancy->achievements}} id="achievements" rows="5"
                  class="form-control @error('achievements') is-invalid @enderror"
                  name="achievements">{{ $applicant->achievements??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('achievements')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->certificates)
    <div class="form-group">
        <label for="certificates"
               class="">{{ __('Certificates') }}</label>
        <textarea {{$vacancy->certificates}} id="certificates" rows="5"
                  class="form-control @error('certificates') is-invalid @enderror"
                  name="certificates">{{ $applicant->certificates??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('certificates')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->skills)
    <div class="form-group">
        <label for="skills"
               class="">{{ __('Skills') }}</label>
        <textarea {{$vacancy->skills}} id="skills" rows="5"
                  class="form-control @error('skills') is-invalid @enderror"
                  name="skills">{{ $applicant->skills??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('skills')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->languages)
    <div class="form-group">
        <label for="languages"
               class="">{{ __('Languages') }}
        </label>
        <textarea {{$vacancy->languages}} id="languages" rows="5"
                  class="form-control @error('languages') is-invalid @enderror"
                  name="languages">{{ $applicant->languages??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('languages')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->interests)
    <div class="form-group">
        <label for="interests"
               class="">{{ __('Interests') }}
        </label>
        <textarea {{$vacancy->interests}} id="interests" rows="5"
                  class="form-control @error('interests') is-invalid @enderror"
                  name="interests">{{ $applicant->interests??'' }}</textarea>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('interests')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->attach_cv)
    <div class="form-group">
        <label for="attach_cv"
               class="">{{ __('Attach CV') }}</label>
        <div class="custom-file">
            <input {{$vacancy->attach_cv}} name="attach_cv" type="file"
                   class="custom-file-input @error('attach_cv') is-invalid @enderror"
                   id="attach_cv">
            <label class="custom-file-label"
                   for="attach_cv">{{$applicant->attach_cv??__('Choose a file')}}</label>
        </div>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('attach_cv')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->cover_letter)
    <div class="form-group">
        <label for="cover_letter"
               class="">{{ __('Attach Cover Letter') }}</label>
        <div class="custom-file">
            <input {{$vacancy->cover_letter}} name="cover_letter" type="file"
                   class="custom-file-input @error('cover_letter') is-invalid @enderror"
                   id="cover_letter">
            <label class="custom-file-label"
                   for="cover_letter">{{$applicant->cover_letter??__('Choose a file')}}</label>
        </div>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('cover_letter')??''}}</strong>
        </span>
    </div>
@endif
@if ($vacancy->linked_in)
    <div class="form-group">
        <label for="linked_in">{{ __('LinkedIn Profile link') }}</label>
        <input id="linked_in" type="text"
               class="form-control @error('linked_in') is-invalid @enderror"
               name="linked_in"
               value="{{ $applicant->linked_in??'' }}" {{$vacancy->linked_in}}>
        <span class="invalid-feedback" role="alert">
            <strong>{{$errors->first('linked_in')??''}}</strong>
        </span>
    </div>
@endif
