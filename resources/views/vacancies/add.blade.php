@extends('layouts.dashboard')

@section('title','Add Vacancy')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create vacancies')
                        <form action="{{route('vacancies.store')}}" method="post" id="createJobForm">
                            @csrf
                            @include('vacancies.form')
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('vacancies.index')}}"
                                   class="btn btn-outline-primary">{{__('Back To List')}}</a>
                                <button class="btn btn-primary">{{ __('Publish') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
