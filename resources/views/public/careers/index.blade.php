@extends('layouts.public')

@section('title', __('Careers'))

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">Careers</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Careers</li>
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
                        <h2>{{ __('Join Our Team') }}</h2>
                        <p class="mt-3 mb-4">{{ __('The following are open vacancies.') }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="iq-login iq-rmt-20">
                            <ul class="list-group list-group-flush vacancies-list">
                                @forelse ($vacancies as $vacancy)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{route('careers.show',['vacancy'=>$vacancy->id])}}">{{$vacancy->position}}</a>
                                        @if ($vacancy->end_date)
                                            <span
                                                class="ml-3 badge badge-primary badge-lg">{{$vacancy->end_date->format('d.m.Y')}}</span>
                                        @endif
                                    </li>
                                @empty
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <p class="lead text-center w-100 m-0">{{ __('Unfortunately, we do not have open vacancies right now.') }}</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
