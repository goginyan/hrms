@extends('layouts.dashboard')

@section('title','Create Document')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="docType">
                            {{__('Choose a type of document you want to create')}}
                        </label>
                        <select name="docType" id="docType"
                                class="form-control custom-select"
                                data-placeholder="Choose Type"
                                data-width="100%">
                            @foreach($docTypes as $type)
                                <option
                                    value="{{$type->id}}" {{$inProcess->contains($type->name)?'disabled':''}}>{{$type->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-between align-items-center mt-5">
                        <a href="{{route('documents.index')}}"
                           class="btn btn-outline-primary">{{__('Back to List')}}</a>
                        <button data-route="{{route('documents.fill',['docType'=>'%fromJs%'])}}" type="button"
                                id="fillDocument" class="btn btn-primary">{{ __('Fill Document') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
