@extends('layouts.dashboard')

@section('title',__('Create Quiz'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="quizForm" enctype="multipart/form-data"
                          action="{{route('quizzes.store')}}" method="post">
                        @csrf
                        @include('quizzes.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('quizzes.index')}}"
                       class="btn btn-outline-primary">{{__('Back to List')}}</a>
                    <button type="submit" form="quizForm" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection