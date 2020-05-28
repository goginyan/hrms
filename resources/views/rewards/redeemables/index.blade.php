@extends('layouts.dashboard')

@section('title',__('Redeemable Products(Services)'))

@section('content')
    <table class="table table-sm table-bordered redeemables-table">
        <thead class="table-primary">
        <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('Title')}}</th>
            <th>{{__('Description')}}</th>
            <th class="text-center">{{__('Image')}}</th>
            <th class="text-center">{{__('Price')}}</th>
            <th>{{__('Created At')}}</th>
            <th class="text-center">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($redeemables as $redeemable)
            <tr>
                <td>{{$redeemable->id}}</td>
                <td>{{$redeemable->title}}</td>
                <td class="text-overflow">{{$redeemable->description}}</td>
                <td class="text-center"><img class="profile-picture profile-picture-sm" src="{{$redeemable->image}}"
                                             alt="Product Image"></td>
                <td class="text-center">{{$redeemable->price}} {{__('point(s)')}}</td>
                <td>{{$redeemable->created_at->format('d.m.Y')}}</td>
                <td class="text-center">
                    <a class="mr-3" href="{{route('redeemables.show',$redeemable)}}">{{__('View')}}</a>
                    <button class="btn btn-link" type="submit"
                            form="destroyRedeemable{{$redeemable->id}}">{{__('Remove')}}</button>
                    <form id="destroyRedeemable{{$redeemable->id}}"
                          action="{{route('redeemables.destroy', $redeemable)}}"
                          method="post">
                        @csrf
                        @method('delete')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"><p class="text-center">{{__('There are not any redeemables added')}}</p></td>
            </tr>
        @endforelse
        @unset($redeemable)
        </tbody>
    </table>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <button data-toggle="modal" data-target="#createRedeemableModal"
                class="btn btn-primary">{{__('Add New')}}</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createRedeemableModal" role="dialog" aria-labelledby="createRedeemableModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="createRedeemableModalLongTitle">{{__('Add New Redeemable Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('redeemables.store')}}" method="post" class="modal-body"
                      enctype="multipart/form-data"
                      id="createRedeemableModalForm">
                    @csrf
                    @include('rewards.redeemables.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="createRedeemableModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="createRedeemableModalForm"
                            class="btn btn-primary">{{__('Create')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection