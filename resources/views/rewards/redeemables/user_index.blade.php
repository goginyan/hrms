@extends('layouts.dashboard')

@section('title',__('Redeemable Products(Services)'))
@php($userPoints = Auth::user()->employee->reward_received)
@section('content')
    <h4 class="mb-3">{{__('My Points:')}} <span
            id="userPoints">{{$userPoints}}</span> {{__('point(s)')}}</h4>
    <div class="row align-items-stretch">
        @forelse ($redeemables as $redeemable)
            <div class="col-6 col-sm-4 col-md-3 mb-4">
                <div class="card redeemable-card {{$redeemable->price<=$userPoints?:'loading'}}">
                    <img class="card-img-top redeemable-image" src="{{$redeemable->image}}" alt="Product Image">
                    <div class="card-body">
                        <h4 class="card-title">{{$redeemable->title}}</h4>
                        <p class="card-text">{{$redeemable->description??__('You can spent your reward points and redeem this product.')}}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button
                            {{$redeemable->price<=$userPoints?:'disabled'}} data-url="{{route('redeemables.redeem',$redeemable)}}"
                            class="btn btn-primary redeem-button" data-toggle="tooltip" data-placement="top"
                            title="{{__('Redeem')}}">{{$redeemable->price}} {{__('point(s)')}}</button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">{{__('There are not any redeemables added')}}</p>
        @endforelse
    </div>
    <div class="redeem-alert-area">
        <div class="alert alert-success alert-dismissible fade">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <span class="alert-message"></span>
        </div>
        <div class="alert alert-danger alert-dismissible fade">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <span class="alert-message"></span>
        </div>
    </div>
@endsection
