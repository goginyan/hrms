@extends('layouts.dashboard')

@section('title',$survey->title)

@section('content')
    <ul class="list-group list-group-flush surveys-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Title')}}</span>
            <span class="badge badge-primary badge-lg">{{$survey->title}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Description')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$survey->description}}</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Employees')}}</span>
            <span class="w-50 d-flex flex-wrap justify-content-end align-items-center">
                @foreach($survey->employees as $employee)
                    <span class="badge badge-primary badge-lg ml-3 mb-1">{{$employee->fullName}}</span>
                @endforeach
            </span>
        </li>
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
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('surveys.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        <button title="Delete Survey" type="submit" form="destroySurvey{{$survey->id}}"
                class="btn btn-danger">
            {{__('Destroy Survey')}}
        </button>
        <a href="{{route('surveys.edit',$survey)}}" class="btn btn-success">{{__('Manage Survey')}}</a>
        <button data-toggle="modal" data-target="#editSurveyModal"
                class="btn btn-primary">{{__('Edit Survey')}}</button>
    </div>
    <form id="destroySurvey{{$survey->id}}"
          action="{{route('surveys.destroy', ['survey'=>$survey->id])}}"
          method="post">
        @csrf
        @method('delete')
    </form>

    <!-- Modal -->
    <div class="modal fade" id="editSurveyModal" role="dialog" aria-labelledby="editSurveyModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSurveyModalLongTitle">{{__('Edit the Survey')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{route('surveys.update',['survey'=>$survey->id])}}"
                      method="post" class="modal-body" id="editSurveyModalForm">
                    @csrf
                    @method('put')
                    @include('surveys.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="editSurveyModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="editSurveyModalForm"
                            class="btn btn-primary">{{__('Update')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
