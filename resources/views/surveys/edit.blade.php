@extends('layouts.dashboard')

@section('title',$survey->title)

@section('content')
    <ul class="list-group list-group-flush surveys-list">
        @if ($survey->expired_at)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{__('Expired At')}}</span>
                <span class="badge badge-primary badge-lg">{{$survey->expired_at->format('d.m.Y')}}</span>
            </li>
        @endif
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Active')}}</span>
            <span class="badge {{$survey->active?"badge-success":"badge-secondary"}} badge-lg"><i
                    class="fas fa-check"></i></span>
        </li>
    </ul>
    @if ($survey->questions->count())
        <h4 class="mb-3">{{__('Questions')}}</h4>
        <ul class="list-group list-group-flush questions-list">
            @foreach($survey->questions as $question)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <a href="{{route('questions.show',[$survey,$question])}}">{{$question->text}}</a>
                        <span class="badge badge-primary badge-lg ml-3">{{$question->type}}</span>
                    </span>
                    <form id="destroyQuestion{{$question->id}}"
                          action="{{route('questions.destroy', [$survey,$question])}}"
                          method="post">
                        @csrf
                        @method('delete')
                    </form>
                    <button title="Remove question" type="submit" form="destroyQuestion{{$question->id}}"
                            class="btn btn-sm btn-circle btn-danger destroy-btn">
                        <i class="fa fa-times"></i>
                    </button>
                </li>
            @endforeach
            @unset($question)
        </ul>
    @endif
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{route('surveys.execute', $survey)}}" class="btn btn-outline-primary">{{__('Save and Exit')}}</a>

        <button data-toggle="modal" data-target="#addQuestionModal"
                class="btn btn-primary">{{__('Add Question')}}</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addQuestionModal" role="dialog" aria-labelledby="addQuestionModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLongTitle">{{__('Add Question')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('questions.store',$survey)}}"
                      method="post" class="modal-body" id="questionForm">
                    @csrf
                    @include('surveys.questions.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="questionForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="questionForm"
                            class="btn btn-primary">{{__('Add')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
