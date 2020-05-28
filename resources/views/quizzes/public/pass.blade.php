@extends('layouts.public')

@section('title',$quiz->title)

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{ $quiz->title }}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item"><span>Quizzes</span>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $quiz->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <img class="img-fluid iq-breadcrumb3-after" src="{{asset('images/theme/about/about-shap.png')}}" alt="image">
    </section>
    <div class="main-content">
        <section class="iq-login-regi">
            <div class="container">
                <div class="row align-items-start">
                    @if($applicant->pivot->result)
                        <div class="col-12">
                            <h2>{{ __('You already passed the quiz') }}</h2>
                            <p class="mt-3 mb-4">{{ $quiz->title }}</p>
                        </div>
                    @else
                        <div class="col-lg-6 col-12 p-0 col-sm-12">
                            <h2>{{ __('Please pass the quiz') }}</h2>
                            <p class="mt-3 mb-4">{{ $quiz->title }}</p>
                        </div>
                        <div class="col-lg-6 col-12 p-0 col-sm-12">
                            <div class="iq-login iq-rmt-20">
                                <form style="line-height: normal"
                                      action="{{route('quizzes.public.store', [$quiz,$applicant])}}" method="post">
                                    @csrf
                                    @foreach($quiz->questions as $question)
                                        <div class="form-group">
                                            <label for="question{{$question->id}}"><h5><i>{{$question->text}}</i></h5>
                                            </label>
                                            @switch($question->type)
                                                @case('range')
                                                <label for="question{{$question->id}}"
                                                       class="d-flex justify-content-between">
                                                    <small>{{$question->answers[0]??0}}</small>
                                                    <small>{{$question->answers[1]??100}}</small>
                                                </label>
                                                <div class="position-relative">
                                                    <input required min="{{$question->answers[0]??0}}"
                                                           max="{{$question->answers[1]??100}}" step="1"
                                                           type="range"
                                                           class="custom-range" id="question{{$question->id}}"
                                                           name="{{$question->id}}">
                                                    <output for="{{$question->id}}"
                                                            onforminput="value = foo.valueAsNumber;"></output>
                                                </div>
                                                @break
                                                @case('checkbox')
                                                @foreach($question->answers as $key => $answer)
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="q{{$question->id}}answer{{$key}}"
                                                               name="{{$question->id}}[]" value="{{$answer}}">
                                                        <label class="custom-control-label"
                                                               for="q{{$question->id}}answer{{$key}}">{{$answer}}</label>
                                                    </div>
                                                @endforeach
                                                @break
                                                @case('radio')
                                                @foreach($question->answers as $key => $answer)
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input"
                                                               id="q{{$question->id}}answer{{$key}}"
                                                               name="{{$question->id}}" value="{{$answer}}">
                                                        <label class="custom-control-label"
                                                               for="q{{$question->id}}answer{{$key}}">{{$answer}}</label>
                                                    </div>
                                                @endforeach
                                                @break
                                                @case('text')
                                                <textarea required class="form-control" name="{{$question->id}}"
                                                          id="question{{$question->id}}"
                                                          rows="5"></textarea>
                                                @break
                                            @endswitch
                                        </div>
                                        @if (!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection