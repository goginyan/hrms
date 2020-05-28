@extends('layouts.dashboard')

@section('title','Plan New Interview')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="applicationForm" enctype="multipart/form-data"
                          action="{{route('interviews.store')}}" method="post">
                        @csrf
                        @include('interviews.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('interviews.index')}}"
                       class="btn btn-outline-primary">{{__('Back to List')}}</a>
                    <button type="submit" form="applicationForm" class="btn btn-primary">{{ __('Plan') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection