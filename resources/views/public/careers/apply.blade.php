@extends('layouts.public')

@section('title', __('Careers'))

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{ $vacancy->position }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('careers.index')}}">Careers</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $vacancy->position }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <img class="img-fluid iq-breadcrumb3-after" src="{{asset('images/theme/about/about-shap.png')}}" alt="image">
    </section>
    <div class="main-content">
        <section class="iq-login-regi">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-lg-6 col-12 p-0 col-sm-12">
                        <h2>{{ __('Join Our Team') }}</h2>
                        <p class="mt-3 mb-4">{{ $vacancy->position }}</p>
                    </div>
                    <div class="col-lg-6 col-12 p-0 col-sm-12">
                        <div class="iq-login iq-rmt-20">
                            <form id="applicationForm" enctype="multipart/form-data"
                                  action="{{route('careers.store',['vacancy'=>$vacancy->id])}}" method="post">
                                @csrf
                                @if ($vacancy->first_name)
                                    <div class="form-group">
                                        <label for="first_name"
                                               class="">{{ __('First Name') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="first_name" type="text"
                                                   class="form-control email-bg @error('first_name') is-invalid @enderror"
                                                   name="first_name"
                                                   value="{{ old('first_name')??"" }}" {{$vacancy->first_name}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('first_name')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->last_name)
                                    <div class="form-group">
                                        <label for="last_name"
                                               class="">{{ __('Last Name') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="last_name" type="text"
                                                   class="form-control email-bg @error('last_name') is-invalid @enderror"
                                                   name="last_name"
                                                   value="{{ old('last_name')??"" }}" {{$vacancy->last_name}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('last_name')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->patronymic)
                                    <div class="form-group">
                                        <label for="patronymic"
                                               class="">{{ __('Patronymic') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="patronymic" type="text"
                                                   class="form-control email-bg @error('patronymic') is-invalid @enderror"
                                                   name="patronymic"
                                                   value="{{ old('patronymic')??"" }}" {{$vacancy->patronymic}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('patronymic')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->photo)
                                    <div class="form-group">
                                        <label for="photo"
                                               class="">{{ __('Photo') }}</label>
                                        <div class="col-12 p-0">
                                            <div class="custom-file">
                                                <input {{$vacancy->photo}} name="photo" type="file"
                                                       class="custom-file-input @error('photo') is-invalid @enderror"
                                                       id="photo">
                                                <label class="custom-file-label"
                                                       for="photo">{{__('Choose a file')}}</label>
                                            </div>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('photo')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->sex)
                                    <div class="form-group">
                                        <label for="sex"
                                               class="">{{ __('Sex') }}</label>
                                        <div class="col-12 p-0">
                                            <select {{$vacancy->sex}} name="sex" id="sex"
                                                    class="form-control email-bg @error('patronymic') is-invalid @enderror">
                                                @foreach ($sexes as $key=>$value)
                                                    <option value="{{$key}}">{{__($value)}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('sex')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->family_status)
                                    <div class="form-group">
                                        <label for="family_status"
                                               class="">{{ __('Family Status') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="family_status" type="text"
                                                   class="form-control email-bg @error('family_status') is-invalid @enderror"
                                                   name="family_status"
                                                   value="{{ old('family_status')??"" }}" {{$vacancy->family_status}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('family_status')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->nationality)
                                    <div class="form-group">
                                        <label for="nationality"
                                               class="">{{ __('Nationality') }}</label>
                                        <div class="col-12 p-0">
                                            <select {{$vacancy->nationality}} data-width="100%" name="nationality"
                                                    id="nationality"
                                                    class="form-control email-bg custom-select @error('patronymic') is-invalid @enderror">
                                                @foreach ($countries as $country)
                                                    @continue(!$country['demonym'])
                                                    <option
                                                        value="{{$country['demonym']}}">{{$country['demonym']}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('nationality')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->phone)
                                    <div class="form-group">
                                        <label for="phone"
                                               class="">{{ __('Phone') }}</label>
                                        <div class="col-12 p-0">
                                            <input data-target="phone" type="tel"
                                                   class="form-control email-bg iti-input @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone')??"" }}" {{$vacancy->phone}}>
                                            <input type="hidden" id="phone"
                                                   name="phone"
                                                   value="{{ old('phone')??"" }}">
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('phone')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->address)
                                    <div class="form-group">
                                        <label for="address"
                                               class="">{{ __('Address') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="address" type="text"
                                                   class="form-control email-bg @error('address') is-invalid @enderror"
                                                   name="address"
                                                   value="{{ old('address')??"" }}" {{$vacancy->address}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('address')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->email)
                                    <div class="form-group">
                                        <label for="email"
                                               class="">{{ __('Email') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="email" type="email"
                                                   class="form-control email-bg @error('email') is-invalid @enderror"
                                                   name="email"
                                                   value="{{ old('email')??"" }}" {{$vacancy->email}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('email')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->education)
                                    <div class="form-group">
                                        <label for="education"
                                               class="">{{ __('Education') }}</label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->education}} id="education" rows="5"
                                                      class="form-control email-bg @error('education') is-invalid @enderror"
                                                      name="education">{{ old('education')??"" }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('education')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->work_experience)
                                    <div class="form-group">
                                        <label for="work_experience"
                                               class="">{{ __('Work Experience') }}</label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->work_experience}} id="work_experience" rows="5"
                                                      class="form-control email-bg @error('work_experience') is-invalid @enderror"
                                                      name="work_experience">{{ old('work_experience')??"" }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('work_experience')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->achievements)
                                    <div class="form-group">
                                        <label for="achievements"
                                               class="">{{ __('Achievements') }}</label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->achievements}} id="achievements" rows="5"
                                                      class="form-control email-bg @error('achievements') is-invalid @enderror"
                                                      name="achievements">{{ old('achievements')??"" }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('achievements')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->certificates)
                                    <div class="form-group">
                                        <label for="certificates"
                                               class="">{{ __('Certificates') }}</label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->certificates}} id="certificates" rows="5"
                                                      class="form-control email-bg @error('certificates') is-invalid @enderror"
                                                      name="certificates">{{ old('certificates')??"" }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('certificates')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->skills)
                                    <div class="form-group">
                                        <label for="skills"
                                               class="">{{ __('Skills') }}</label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->skills}} id="skills" rows="5"
                                                      class="form-control email-bg @error('skills') is-invalid @enderror"
                                                      name="skills">{{ old('skills')??"" }}</textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('skills')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->languages)
                                    <div class="form-group">
                                        <label for="languages"
                                               class="">{{ __('Languages') }}
                                        </label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->languages}} id="languages" rows="5"
                                                      class="form-control email-bg @error('languages') is-invalid @enderror"
                                                      name="languages">{{ old('languages')??"" }}
                                            </textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('languages')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->interests)
                                    <div class="form-group">
                                        <label for="interests"
                                               class="">{{ __('Interests') }}
                                        </label>
                                        <div class="col-12 p-0">
                                            <textarea {{$vacancy->interests}} id="interests" rows="5"
                                                      class="form-control email-bg @error('interests') is-invalid @enderror"
                                                      name="interests">{{ old('interests')??"" }}
                                            </textarea>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('interests')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->attach_cv)
                                    <div class="form-group">
                                        <label for="attach_cv"
                                               class="">{{ __('Attach CV') }}</label>
                                        <div class="col-12 p-0">
                                            <div class="custom-file">
                                                <input {{$vacancy->attach_cv}} name="attach_cv" type="file"
                                                       class="custom-file-input @error('attach_cv') is-invalid @enderror"
                                                       id="attach_cv">
                                                <label class="custom-file-label"
                                                       for="attach_cv">{{__('Choose a file')}}</label>
                                            </div>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('attach_cv')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->cover_letter)
                                    <div class="form-group">
                                        <label for="cover_letter"
                                               class="">{{ __('Attach Cover Letter') }}</label>
                                        <div class="col-12 p-0">
                                            <div class="custom-file">
                                                <input {{$vacancy->cover_letter}} name="cover_letter" type="file"
                                                       class="custom-file-input @error('cover_letter') is-invalid @enderror"
                                                       id="cover_letter">
                                                <label class="custom-file-label"
                                                       for="cover_letter">{{__('Choose a file')}}</label>
                                            </div>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('cover_letter')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if ($vacancy->linked_in)
                                    <div class="form-group">
                                        <label for="linked_in"
                                               class="">{{ __('LinkedIn Profile link') }}</label>
                                        <div class="col-12 p-0">
                                            <input id="linked_in" type="text"
                                                   class="form-control email-bg @error('linked_in') is-invalid @enderror"
                                                   name="linked_in"
                                                   value="{{ old('linked_in')??"" }}" {{$vacancy->linked_in}}>
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{$errors->first('linked_in')??""}}</strong>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-block btn-outline-primary">{{__('Apply')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
