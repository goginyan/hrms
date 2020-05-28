@extends('layouts.dashboard')

@section('title','Edit Document Type')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('update doc-types')
                        <form id="docTypeForm" action="{{route('doc-types.update',['docType'=>$docType->id])}}"
                              method="post">
                            @csrf
                            @method('put')
                            @include('doc_types.form',['docFields'=>$docFields, 'docType'=>$docType])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('doc-types.index')}}"
                                   class="btn btn-outline-primary">{{__('Back to List')}}</a>
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
