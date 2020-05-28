@extends('layouts.dashboard')

@section('title','Surveys')

@section('content')
    @if (!empty($errors))
        <div class="d-flex flex-column justify-content-end align-items-center">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    {{__($error)}}
                    <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        </div>
    @endif
    <ul class="list-group list-group-flush surveys-list">
        @foreach($surveys as $survey)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{route('surveys.show', ['survey'=>$survey->id])}}">
                    {{$survey->title}}
                    @if ($survey->author)
                        <span
                            class="ml-3 badge badge-primary badge-lg">{{__("Created By ")}} {{$survey->author->fullName}}</span>
                    @endif
                </a>
                <form id="destroySurvey{{$survey->id}}"
                      action="{{route('surveys.destroy', ['survey'=>$survey->id])}}"
                      method="post">
                    @csrf
                    @method('delete')
                </form>
                <button title="Delete Survey" type="submit" form="destroySurvey{{$survey->id}}"
                        class="btn btn-sm btn-circle btn-danger destroy-btn">
                    <i class="fa fa-times"></i>
                </button>
            </li>
        @endforeach
        @unset($survey)
    </ul>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <button data-toggle="modal" data-target="#createSurveyModal"
                class="btn btn-primary">{{__('Add Survey')}}</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createSurveyModal" role="dialog" aria-labelledby="createSurveyModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSurveyModalLongTitle">{{__('Create new Survey')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{route('surveys.store')}}" method="post" class="modal-body"
                      id="createSurveyModalForm">
                    @csrf
                    @include('surveys.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="createSurveyModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="createSurveyModalForm" class="btn btn-primary">{{__('Create')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection