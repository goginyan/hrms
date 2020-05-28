@extends('layouts.dashboard')

@section('title','Add Document Type')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create doc-types')
                        <form action="{{route('doc-types.store')}}" method="post">
                            @csrf
                            @include('doc_types.form',['docFields'=>$docFields])
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('doc-types.index')}}"
                                   class="btn btn-outline-primary">{{__('Back to List')}}</a>
                                <button class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
