@extends('layouts.dashboard')

@section('title','Edit Settings')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('manage settings')
                        <form id="settingForm" enctype="multipart/form-data"
                              action="{{route('settings.update',['setting'=>$setting->id])}}"
                              method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="company_name">{{ __('Company Name') }}</label>
                                <input value="{{$setting->company_name}}" type="text" id="company_name"
                                       name="company_name"
                                       class="form-control {{$errors->has('company_name')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('company_name')??""}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="logo">{{ __('Company Logo') }}</label>
                                <div class="d-flex align-items-center">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input {{$errors->has('company_logo')?"is-invalid":""}}"
                                                   id="company_logo"
                                                   name="company_logo">
                                            <div class="invalid-feedback">
                                                {{$errors->first('company_logo')??""}}
                                            </div>
                                            <label class="custom-file-label" for="company_logo">Choose file</label>
                                        </div>
                                    </div>
                                    <img class="ml-4" width="40" height="40" src="{{$setting->company_logo}}" alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="language">{{ __('App Language') }}</label>
                                <input value="{{$setting->language}}" type="text" name="language" id="language"
                                       class="form-control {{$errors->has('language')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('language')??""}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="timezone">{{ __('App Timezone') }}</label>
                                <input value="{{$setting->timezone}}" type="text" name="timezone" id="timezone"
                                       class="form-control {{$errors->has('timezone')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('timezone')??""}}
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="email">{{ __('Super Admin E-Mail') }}</label>
                                <input required value="{{$admin->email}}" type="text" name="email" id="email"
                                       class="form-control {{$errors->has('email')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('email')??""}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Super Admin Password') }}</label>
                                <input type="password" name="password" id="password"
                                       class="form-control {{$errors->has('password')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('password')??""}}
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="mail_from">{{ __('Default "From" Address') }}</label>
                                <input value="{{$setting->mail_from}}" type="email" name="mail_from" id="mail_from"
                                       class="form-control {{$errors->has('mail_from')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('mail_from')??""}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mail_name">{{ __('Default "From" Name') }}</label>
                                <input value="{{$setting->mail_name}}" type="text" name="mail_name" id="mail_name"
                                       class="form-control {{$errors->has('mail_name')?"is-invalid":""}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('mail_name')??""}}
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
