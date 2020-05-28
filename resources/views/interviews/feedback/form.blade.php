@extends('layouts.dashboard')

@section('title',__('Leave Feedback'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <a href="{{route('interviews.show',$interview)}}">{{__('Interview')}} #{{$interview->id}}</a>
                        {{__('is ended')}}. {{__('Please leave your feedback for')}}
                        <a href="{{route('applicants.show',$interview->applicant)}}">{{$interview->applicant->first_name??__("No Name")}} {{$interview->applicant->last_name??''}}</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form id="feedbackForm" action="{{route('interviews.feedback.store',$interview)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="feedback">{{__('How much do you rate this candidate')}}</label>
                            <label for="feedback" class="d-flex justify-content-between">
                                <small>1</small>
                                <small>10</small>
                            </label>
                            <input required min="1" max="10" step="1" value="{{$feedback['rate']??''}}"
                                   type="range" class="custom-range" id="feedback" name="feedback_rate">
                        </div>
                        <div class="form-group">
                            <label for="comment">{{__('Your feedback on this candidate')}}</label>
                            <textarea required class="form-control" name="feedback_comment" id="comment" cols="30"
                                      rows="10">{{$feedback['comment']??''}}</textarea>
                        </div>
                    </form>
                </div>
                <div class="card-footer form-group d-flex justify-content-between align-items-center mt-4">
                    <a href="{{route('dashboard')}}"
                       class="btn btn-outline-primary">{{__('Back to Dashboard')}}</a>
                    <button type="submit" form="feedbackForm" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection