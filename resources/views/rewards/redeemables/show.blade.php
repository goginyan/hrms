@extends('layouts.dashboard')

@section('title', $redeemable->title)

@section('content')
    <ul class="list-group list-group-flush redeemables-list">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Title')}}</span>
            <span class="badge badge-primary badge-lg">{{$redeemable->title}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Description')}}</span>
            <div class="d-flex justify-content-end w-50">
                <span class="badge badge-primary badge-lg">{{$redeemable->description}}</span>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Price')}}</span>
            <span class="badge badge-primary badge-lg">{{$redeemable->price}} {{__('point(s)')}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Image')}}</span>
            <a target="_blank" href="{{$redeemable->image}}"><img class="profile-picture profile-picture-sm"
                                                                  src="{{$redeemable->image}}" alt="Product Image"></a>
        </li>
    </ul>
    <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
        <a href="{{route('redeemables.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
        <button title="Remove Redeemable" type="submit" form="destroyRedeemable{{$redeemable->id}}"
                class="btn btn-danger">
            {{__('Remove Redeemable')}}
        </button>
        <button data-toggle="modal" data-target="#editRedeemableModal"
                class="btn btn-primary">{{__('Edit Redeemable')}}</button>
    </div>
    <form id="destroyRedeemable{{$redeemable->id}}"
          action="{{route('redeemables.destroy', $redeemable)}}"
          method="post">
        @csrf
        @method('delete')
    </form>
    <!-- Modal -->
    <div class="modal fade" id="editRedeemableModal" role="dialog" aria-labelledby="editRedeemableModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRedeemableModalLongTitle">{{__('Edit Redeemable Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('redeemables.update', $redeemable)}}" method="post" class="modal-body"
                      enctype="multipart/form-data"
                      id="editRedeemableModalForm">
                    @csrf
                    @method('put')
                    @include('rewards.redeemables.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="editRedeemableModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="editRedeemableModalForm"
                            class="btn btn-primary">{{__('Update')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
