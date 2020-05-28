@extends('layouts.dashboard')

@section('title','Document Approve')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <form method="post" action="{{route('documents.update',['document'=>$document->id])}}">
                @csrf
                @method('put')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="m-0 d-flex justify-content-between align-items-center">
                            {{$document->type->display_name}}
                            @unless ($document->rejected)
                                <span
                                    class="badge badge-secondary badge-lg">{{$document->author->first_name??""}} {{$document->author->last_name??""}}</span>
                            @endunless
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($document->fields as $label=>$value)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{$label}}:</span>
                                    <span>{{$value}}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="form-group">
                            <label for="comment{{$document->id}}"
                                   class="btn btn-link text-danger reject-comment">{{__("Rejecting Comment")}}</label>
                            <textarea name="comment" id="comment{{$document->id}}" class="form-control d-none"
                                      rows="5"></textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <input type="hidden" name="approved" value="0">
                        @can('approve',$document)
                            <button type="button" class="btn btn-danger reject-btn">{{__("Reject")}}</button>
                            <button type="button" class="btn btn-primary approve-btn">{{__("Approve")}}</button>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection