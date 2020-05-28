@extends('layouts.public')

@section('title', __('Need to Verify'))

@section('content')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{ __('Verify Your Email Address') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Need to Verify') }}</li>
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
                        <h2>{{ __('Need to Verify') }}</h2>
                        <p class="mt-3 mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                        <p class="mt-3 mb-4">{{ __('If you did not receive the email, click here to request another.') }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="iq-login iq-rmt-20">
                            <a href="{{ route('verification.resend') }}" class="btn btn-primary">{{__('Resubmit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
