@extends('layouts.dashboard')

@section('title','Document Details')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                @can('view', $document)
                    <div class="card-header">
                        <h5 class="m-0 d-flex justify-content-between align-items-center">
                            {{$document->type->display_name}}
                            @unless ($document->rejected)
                                <span class="badge badge-secondary badge-lg">{{$document->waiting->fullName??""}}</span>
                            @endunless
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($document->rejected)
                            <p class="text-danger mb-4">
                                {{$document->comment}}
                            </p>
                        @endif
                        <ul class="list-group list-group-flush">
                            @foreach($document->fields as $label=>$value)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{$label}}:</span>
                                    <span>{{$value}}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="form-group d-flex align-items-center mt-5 justify-content-between">
                            <a href="{{route('documents.index')}}"
                               class="btn btn-outline-primary">{{__('Back to List')}}</a>
                            @if ($document->rejected)
                                <a href="{{route('documents.resubmit',$document)}}" class="btn btn-primary">
                                    {{__('Resubmit')}}
                                </a>
                            @endif
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection