@extends('layouts.dashboard')

@section('title',__('Edit Vacancy Applicant'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="applicationForm" enctype="multipart/form-data"
                          action="{{route('applicants.update',$applicant)}}" method="post">
                        @csrf
                        @method('put')
                        @include('applicants.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('applicants.show',$applicant)}}"
                       class="btn btn-outline-primary">{{__('Cancel')}}</a>
                    <button type="submit" form="applicationForm" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection