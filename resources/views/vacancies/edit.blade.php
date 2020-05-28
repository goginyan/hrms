@extends('layouts.dashboard')

@section('title','Edit Vacancy')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('update vacancies')
                        <form id="jobForm" action="{{route('vacancies.update',$vacancy)}}"
                              method="post">
                            @csrf
                            @method('put')
                            @include('vacancies.form')
                            <div class="form-group d-flex justify-content-end align-items-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           {{$vacancy->published?"checked":""}} id="published" value="1"
                                           name="published">
                                    <label class="custom-control-label" for="published">{{ __('Published') }}</label>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('vacancies.index')}}"
                                   class="btn btn-outline-primary">{{__('Back To List')}}</a>
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
