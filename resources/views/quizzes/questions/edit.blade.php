@extends('layouts.dashboard')

@section('title',__('Edit Question'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="questionForm" enctype="multipart/form-data"
                          action="{{route('quiz.questions.update',$question)}}" method="post">
                        @csrf
                        @method('put')
                        @include('quizzes.questions.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{back()->getTargetUrl()}}"
                       class="btn btn-outline-primary">{{__('Back')}}</a>
                    <button type="submit" form="questionForm" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection