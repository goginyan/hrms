@extends('layouts.public')

@section('title', __('Sign In'))

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{__('Sign In')}}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Sign In</li>
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
                        <h2>{{ __('Sign In to Dashboard') }}</h2>
                        <p class="mt-3 mb-4">{{ __('Fill the form bellow.') }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="iq-login iq-rmt-20">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email" class="">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                           class="form-control email-bg @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password" class="">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                           class="form-control email-bg @error('password') is-invalid @enderror"
                                           name="password" required
                                           autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div class="form-check d-flex align-items-center mr-4">
                                        <input class="form-check-input mt-0" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-outline-primary btn-block">
                                        {{ __('Login') }}
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
