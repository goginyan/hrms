@extends('layouts.dashboard')

@section('title',__('Edit Interview') . ' #' . $interview->id)

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="interviewForm" enctype="multipart/form-data"
                          action="{{route('interviews.update',$interview)}}" method="post">
                        @csrf
                        @method('put')
                        @include('interviews.form')
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('interviews.show',$interview)}}"
                       class="btn btn-outline-primary">{{__('Back')}}</a>
                    <button type="submit" form="interviewForm" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection