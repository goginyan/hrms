@extends('layouts.dashboard')

@section('title','Create Vacancy Applicant')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="applicationForm" enctype="multipart/form-data"
                          action="{{route('applicants.store', ['vacancy'=>$vacancy->id])}}" method="post">
                        @csrf
                        @include('applicants.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('applicants.index')}}"
                       class="btn btn-outline-primary">{{__('Back to List')}}</a>
                    <button type="submit" form="applicationForm" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection