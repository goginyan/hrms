@extends('layouts.dashboard')

@section('title','Documents')

@section('content')
    @unless ($forApprove->isEmpty())
        <div class="list-group list-group-flush mb-4 border">
            @foreach ($forApprove as $document)
                <a href="{{route('documents.approve',['document'=>$document->id])}}"
                   class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{$document->type->display_name}}</span>
                    <span class="badge badge-success badge-lg">{{$document->author->fullName}}</span>
                </a>
            @endforeach
        </div>
    @endunless
    <table class="table table-bordered table-striped table-sm bg-light">
        <thead class="table-primary">
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Submit Date</th>
            <th>Waiting</th>
            <th class="text-center">Approved</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody class="table-hover">
        @if($documents->isEmpty())
            <tr>
                <td colspan="6" class="text-center">
                    {{__("You don't have any actual documents submitted for approve yet")}}
                </td>
            </tr>
        @else
            @foreach($documents as $document)
                <tr>
                    <td>{{$document->id}}</td>
                    <td>{{$document->type->display_name}}</td>
                    <td>{{$document->created_at}}</td>
                    <td>{{$document->waiting->first_name??""}} {{$document->waiting->last_name??""}}</td>
                    <td class="text-center align-middle">
                        <span
                            class="badge badge-pill badge-{{$document->approved?"success":$document->rejected?"danger":"secondary"}}">&nbsp;</span>
                        @if ($document->rejected)
                            <span class="ml-3">{{$document->rejectedBy->fullName}}</span>
                        @endif
                    </td>
                    <td class="w-25">
                        <div class="d-flex justify-content-center align-items-center">
                            @can('view', $document)
                                <a class="btn btn-primary btn-sm btn-circle mx-4"
                                   href="{{route('documents.show',['document'=>$document->id])}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endcan
                            @can('delete', $document)
                                <form id="destroyDocument{{$document->id}}"
                                      action="{{route('documents.destroy', ['document'=>$document->id])}}"
                                      method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button title="Cancel Document" type="submit" form="destroyDocument{{$document->id}}"
                                        class="btn btn-danger btn-sm btn-circle destroy-btn mx-4">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <a href="{{route('documents.create')}}" class="btn btn-primary">Create Document</a>
    </div>
@endsection
