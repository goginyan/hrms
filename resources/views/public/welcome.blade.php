@extends('layouts.public')

@section('title', __('Welcome'))

@section('content')
    <div class="banner main-bg ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-text">
                        <h1 class="font-weight-bold text-white mb-3">HR software with heart.</h1>
                        <p class="text-white mb-4"><b>Faveo</b> lets you concentrate on people, not processes.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner-type">
                        <img class="img-fluid banner-round wow fadeIn animated bounce slower"
                             src="{{asset('images/theme/banner/02.png')}}">
                        <div class="wow fadeInRight">
                            <img class="img-fluid banner-person" src="{{asset('images/theme/banner/03.png')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="img-fluid banner-after" src="{{asset('images/theme/banner/shap.png')}}" alt="image">
        <div class="content--canvas">
        </div>
    </div>
    <section class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="{{asset('images/theme/bg/01.png')}}" class="img-fluid wow fadeInLeft" alt="">
                </div>
                <div class="col-lg-6 align-self-center">
                    <h2 class="mb-3 iq-rmt-30 font-weight-bold">About Us</h2>
                    <p> Our HR software collects and arranges all the data you gather throughout the employee lifespan,
                        then
                        helps you use it to achieve grand things. Whether you’re hiring, onboarding, preparing
                        compensation,
                        or building culture, FaveoHR gives you the time and insights to concentrate on your most
                        important
                        asset—your people.</p>
                    <ul class="list-style mt-4">
                        <li><i class="fas fa-chart-pie blue-color"></i><span class="font-weight-bold text-black">It is a
                                long established fact that a reader</span>
                        </li>
                        <li><i class="fas fa-chart-bar blue-color"></i><span class="font-weight-bold text-black">Printing
                                and typesetting industry</span>
                        </li>
                        <li><i class="fas fa-chart-line blue-color"></i><span class="font-weight-bold text-black">Galley
                                of type and scrambled</span>
                        </li>
                        <li><i class="fas fa-cogs blue-color"></i><span class="font-weight-bold text-black">Electronic
                                typesetting</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
