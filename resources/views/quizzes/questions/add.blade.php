@extends('layouts.dashboard')

@section('title',__('Create Question'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="questionForm" enctype="multipart/form-data"
                          action="{{route('quiz.questions.store')}}" method="post">
                        @csrf
                        @include('quizzes.questions.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('quiz.questions.index')}}"
                       class="btn btn-outline-primary">{{__('Back to List')}}</a>
                    <button type="submit" form="questionForm" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection