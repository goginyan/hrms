@extends('layouts.dashboard')

@section('title',$survey->title)

@section('content')
    <ul class="list-group list-group-flush question-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Question')}}</span>
            <span class="badge badge-primary badge-lg">{{$question->text}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Type')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$types[$question->type]}}</span>
            </div>
        </li>
        @if ($question->type !== 'text')
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{__('Answers')}}</span>
                <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                    @foreach($question->answers as $answer)
                        <span class="badge badge-primary badge-lg ml-3 mb-1">{{$answer}}</span>
                    @endforeach
                </span>
            </li>
        @endif
    </ul>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('surveys.edit',$survey)}}" class="btn btn-outline-primary">{{__('Back to Survey')}}</a>
        <button type="submit" form="destroyQuestion{{$question->id}}"
                class="btn btn-danger">
            {{__('Remove Question')}}
        </button>
        <button data-toggle="modal" data-target="#editQuestionModal"
                class="btn btn-primary">{{__('Edit Question')}}</button>
    </div>
    <form id="destroyQuestion{{$question->id}}"
          action="{{route('questions.destroy', [$survey, $question])}}"
          method="post">
        @csrf
        @method('delete')
    </form>

    <!-- Modal -->
    <div class="modal fade" id="editQuestionModal" role="dialog" aria-labelledby="editQuestionModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuestionModalLongTitle">{{__('Edit the Question')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('questions.update', $question)}}"
                      method="post" class="modal-body" id="editQuestionModalForm">
                    @csrf
                    @method('put')
                    @include('surveys.questions.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="editQuestionModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="editQuestionModalForm"
                            class="btn btn-primary">{{__('Update')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
