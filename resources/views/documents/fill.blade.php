@extends('layouts.dashboard')

@section('title','Fill the Document')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">{{$docType->display_name}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('documents.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="hidden_doc_type" value="{{$docType->id}}">
                        @foreach($docType->fields as $field)
                            @include('doc_fields.field', [
                                'id' => uniqid('doc'),
                                'label' => $field->pivot->field_name,
                                'type' => $field->partial,
                                'value'=> $document->fields[$field->pivot->field_name]??null
                            ])
                        @endforeach
                        <div class="form-group d-flex justify-content-between align-items-center mt-5">
                            <a href="{{route('documents.create')}}" class="btn btn-outline-primary">{{__('Cancel')}}</a>
                            @can('fill',[App\Models\Document::class, $docType])
                                <button class="btn btn-primary">{{ __('Submit Document') }}</button>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
