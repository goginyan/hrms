<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="shortcut icon" href="{{asset('images/hrms_logo.png')}}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{--Select2--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Select2 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet"/>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link href="{{ asset('css/typography.css') }}" rel="stylesheet">
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="{{route('home')}}">
                        <img src="{{asset('images/hrms_logo_light.png')}}" class="img-fluid logo" alt="img">
                        <img src="{{asset('images/hrms_logo.png')}}" class="img-fluid logo-white" alt="img">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                                <a class="nav-link"
                                   href="{{ url('/') }}">{{__('Home')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('blog.index')}}">{{__('Blog')}}</a>
                            </li>
                            <li class="nav-item {{ Request::is('careers*') ? 'active' : '' }}">
                                <a class="nav-link"
                                   href="{{route('careers.index')}}">{{__('Careers')}}</a>
                            </li>
                            <li class="nav-item {{ Request::is('contacts') ? 'active' : '' }}">
                                <a class="nav-link"
                                   href="#">{{__('Contacts')}}</a>
                            </li>
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('dashboard') }}">{{__('Dashboard')}}</a>
                                </li>
                            @else
                                <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
                                    <a class="nav-link"
                                       href="{{ route('login') }}">{{__('Sign In')}}</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer id="contact" class="iq-footerr main-bg fshap ">
    <img class="img-fluid fshap-after" src="{{asset('images/theme/banner/fshap.png')}}" alt="image">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6 ">
                    <h4 class="text-white  mb-3">Menu</h4>
                    <ul class="menu">
                        <li><a href="{{route('home')}}">Home</a></li>
                        <li><a href="{{route('blog.index')}}">Blog</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="{{route('careers.index')}}">Careers</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 iq-rmt-20">
                    <h4 class="text-white  mb-3">Subscribe To Newsletter</h4>
                    <form class="form-inline mb-5">
                        <div class="form-group">
                            <input type="text" class="form-control search-btn" placeholder="Email">
                        </div>
                        <a href="JavaScript:Void(0);" class="button submit-btn">Submit</a>
                    </form>
                    <span class="text-white d-inline">Follow Us :</span>
                    <ul class="info-share d-inline">
                        <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fab fa-google"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fab fa-github"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="contact-bg">
                        <h4 class="text-white iq-rmt-30  mb-3">Address</h4>
                        <ul class="iq-contact text-white">
                            <li>
                                <i class="fas fa-phone"></i>
                                <p>+0123 456 789</p>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <p class="link"><a href="mailto:test@example.com">test@example.com</a></p>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Carol J. Stephens 1635 Franklin, Montgomery, AL 36104 USA</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 ">
                    <div class="logo iq-rmt-30">
                        <a href="{{route('home')}}"><img src="{{asset('images/hrms_logo_light.png')}}" class="img-fluid"
                                                         alt="img">
                            <p class="ml-3 d-inline text-white">HRMS</p></a>
                        <p class="mt-3 text-white">Been the industry's standard dummy text ever since the 1500s.</p>
                        <div class="mt-3 text-white link">Design by
                            <a href="https://iqonicthemes.com/"> iqonictheme.com </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="back-to-top">
        <a class="top" id="top" href="#top"><span>Scroll Up</span> <i class="fa fa-arrow-up"></i></a>
    </div>

</footer>
{{--Application script--}}
<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('js/public.js')}}"></script>
<script src="{{asset('js/countdown.js')}}"></script>
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('js/wow.min.js')}}"></script>
<script src="{{asset('js/counto.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>
