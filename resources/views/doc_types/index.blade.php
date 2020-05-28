@extends('layouts.dashboard')

@section('title','Documents Types')

@section('content')
    @can('view doc-types')
        <ul class="list-group list-group-flush docTypes-list">
            @foreach($docTypes as $docType)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{route('doc-types.show', $docType)}}">
                        {{$docType->display_name}} ({{$docType->name}})
                    </a>
                </li>
            @endforeach
        </ul>
    @endcan
    @can('create doc-types')
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('doc-types.create')}}" class="btn btn-primary">Add DocType</a>
        </div>
    @endcan
@endsection
