@extends('layouts.dashboard')

@section('title',__('Rewards'))

@section('content')
    <h4 class="mb-3"><label for="rewardPost">{{__('Who do you want to reward?')}}</label></h4>
    <div class="row mb-4">
        <div class="col-12 col-sm-8">
            <form action="" method="POST">
                <div class="reward-post">
                    <div contenteditable="true"
                        data-placeholder="{{__('Type @ symbol to pull up the company employee. Type # to use hashtags')}}"
                         id="rewardPost" class="form-control"></div>
                    <input type="hidden" name="rewarded" id="rewardingEmployee">
                    <input type="hidden" name="points" id="rewardingPoints" value="5">
                </div>
            </form>
        </div>
        <div class="col-12 col-sm-4 d-flex flex-column justify-content-between align-items-center">
            <div class="badge badge-primary badge-lg d-flex flex-column p-3 w-100">
                <h5 class="text-light mb-3">{{__('Received Reward:')}} <span
                        id="receivedPoints">{{$receivedPoints}}</span> {{__('point(s)')}}</h5>
                <h5 class="text-light mb-0">{{__('Points for Reward:')}} <span
                        id="leftPoints">{{$leftPoints}}</span> {{__('point(s)')}}</h5>
            </div>
            <div class="action-buttons d-flex align-items-center justify-content-center">
                <button id="emojiPicker" class="btn btn-circle btn-info"><i class="fas fa-smile"></i></button>
                <button id="gifPicker" class="btn btn-circle btn-info mx-3"><i class="fas fa-sticky-note"></i></button>
                <div class="points-dropdown dropdown">
                    <button class="btn btn-success" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        +<span class="active-reward mr-2">5</span> {{__('points')}} <small class="ml-3"><i
                                class="fas fa-chevron-down"></i></small>
                    </button>
                    <div class="dropdown-menu dropdown-success" aria-labelledby="dropdownMenuButton">
                        <a data-value="5" class="dropdown-item active" href="javascript:void(0)">+5 {{__('points')}}</a>
                        <a data-value="10" class="dropdown-item" href="javascript:void(0)">+10 {{__('points')}}</a>
                        <a data-value="25" class="dropdown-item" href="javascript:void(0)">+25 {{__('points')}}</a>
                        <a data-value="50" class="dropdown-item" href="javascript:void(0)">+50 {{__('points')}}</a>
                    </div>
                </div>
            </div>
            <div id="emojiContainer"></div>
            <button class="btn btn-block btn-primary" id="rewardPublish">{{__('Reward')}}</button>
        </div>
    </div>
    {{--    <div id="gif-wrap"></div>--}}
    {{--    <div id="gif-logo"><img src="https://storage.googleapis.com/chydlx/codepen/random-gif-generator/giphy-logo.gif"/></div>--}}
    {{--    <button id="new-gif">New Gif</button>--}}
@endsection

@push('script')
    <script>
        const employees = JSON.parse(`{!! $employees !!}`);
    </script>
    <script src="{{asset('js/rewards.js')}}"></script>
@endpush
