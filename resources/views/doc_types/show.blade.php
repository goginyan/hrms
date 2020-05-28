@extends('layouts.dashboard')

@section('title','Document Type')

@section('content')
    @can('view doc-types')
        <h4>{{$docType->display_name}} ({{$docType->name}}) - Fields</h4>
        <ul class="list-group list-group-flush docTypes-list mt-2 mb-3">
            @foreach($docType->fields as $field)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{$field->pivot->field_name}}</span>
                    <span class="badge badge-primary badge-lg">{{$field->name}}</span>
                </li>
            @endforeach
        </ul>
        <h4>{{$docType->display_name}} ({{$docType->name}}) - Approve Flow</h4>
        <ul class="list-group list-group-flush docTypes-list mt-2 mb-3">
            @foreach($docType->approveRoles as $role)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{$role->display_name}}</span>
                    <span class="badge badge-primary badge-lg">{{$role->pivot->sequence}}</span>
                </li>
            @endforeach
        </ul>
        <h4>{{$docType->display_name}} ({{$docType->name}}) - Can Create</h4>
        <ul class="list-group list-group-horizontal docTypes-list mt-2">
            @foreach($docType->createRoles as $role)
                <li class="list-group-item mr-3">
                    <span>{{$role->display_name}}</span>
                </li>
            @endforeach
        </ul>
    @endcan
    <div class="d-flex justify-content-between align-items-center mt-4">
        @can('view doc-types')
            <a href="{{route('doc-types.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        @endcan
        @can('delete doc-types')
            <form id="destroyDocType" class="d-none"
                  action="{{route('doc-types.destroy', ['docType'=>$docType->id])}}"
                  method="post">
                @csrf
                @method('delete')
            </form>
            <button type="submit" form="destroyDocType"
                    class="btn btn-danger">
                Remove DocType
            </button>
        @endcan
        @can('update doc-types')
            <a href="{{route('doc-types.edit', ['docType'=>$docType->id])}}" class="btn btn-primary">Edit DocType</a>
        @endcan
    </div>
@endsection
