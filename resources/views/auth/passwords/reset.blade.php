@extends('layouts.public')

@section('title', __('New Password'))

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{ __('New Password') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('New Password') }}</li>
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
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{ __('Invite new password') }}</h2>
                        <p class="mt-3 mb-4">{{ __('Fill the form bellow.') }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="iq-login iq-rmt-20">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                           class="form-control email-bg @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                           class="form-control email-bg @error('password') is-invalid @enderror"
                                           name="password"
                                           required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control email-bg"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
