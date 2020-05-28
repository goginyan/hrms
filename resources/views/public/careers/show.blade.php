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
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{ __('Join Our Team') }}</h2>
                        <p class="mt-3 mb-4">{{ $vacancy->position }}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="iq-login iq-rmt-20">
                            <ul class="list-group list-group-flush vacancies-list">
                                @forelse ($vacancy->attributesToArray() as $attr=>$value)
                                    @continue(!$value || $value=='optional'||$value=='required')
                                    @switch($attr)
                                        @case ('contact_person_id')
                                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                                            {{__('Contact Person')}}
                                            <span
                                                class="ml-3 badge badge-primary badge-lg">{{$vacancy->contactPerson->fullName}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                                            {{__('Contact Person Title')}}
                                            <span
                                                class="ml-3 badge badge-primary badge-lg">{{$vacancy->contactPersonTitle}}</span>
                                        </li>
                                        @break
                                        @case('position')
                                        @case('updated_at')
                                        @case('created_at')
                                        @case('deleted_at')
                                        @case('salary_currency')
                                        @case('id')
                                        @break
                                        @case('salary')
                                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                                            {{\Illuminate\Support\Str::title(str_replace('_',' ',$attr))}}
                                            <span
                                                class="ml-3 badge badge-primary badge-lg">{{$value}} {{$vacancy->salary_currency}}</span>
                                        </li>
                                        @break
                                        @case('open_date')
                                        @case('end_date')
                                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                                            {{\Illuminate\Support\Str::title(str_replace('_',' ',$attr))}}
                                            <span
                                                class="ml-3 badge badge-primary badge-lg">{{$value->format('d.m.Y')}}</span>
                                        </li>
                                        @break
                                        @default
                                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                                            {{\Illuminate\Support\Str::title(str_replace('_',' ',$attr))}}
                                            <span class="ml-3 badge badge-primary badge-lg">{{$value}}</span>
                                        </li>
                                        @break
                                    @endswitch
                                @empty
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <p class="lead text-center w-100 m-0">{{ __('You can send your CV to our email.') }}</p>
                                    </li>
                                @endforelse
                            </ul>
                            @if ($vacancy->with_form)
                                <p class="lead text-center mt-4">
                                    <a href="{{ route('careers.apply',['vacancy'=>$vacancy->id]) }}"
                                       class="btn btn-lg btn-outline-primary">{{__('Application Form')}}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
