@extends('layouts.dashboard')

@section('title','Team Details')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 d-flex align-items-center justify-content-between">
                        {{$team->name}}
                        <span>
                            <span title="{{__('Team creator')}}"
                                  class="badge badge-secondary badge-lg ml-2">by {{$team->creator->first()->fullName??'Super Administrator'}}</span>
                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{route('teams.update',['team'=>$team->id])}}" method="post"
                          id="membersForm">
                        @csrf
                        @method('patch')
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <label class="m-0 w-50">{{ __('Team Purpose') }}</label>
                                <span class="badge badge-primary badge-lg ml-2">{{$team->purpose}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <label class="m-0 w-50">{{ __('Description') }}</label>
                                <span class="badge badge-primary badge-lg ml-2">{{$team->description}}</span>
                            </li>
                            @foreach ($team->members as $member)
                                @continue(!$team->creator->isEmpty() && $member->id==$team->creator->first()->id)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <label for="role{{$member->id}}" class="m-0 w-75">{{ $member->fullName }}</label>
                                    @can('update', $team)
                                        <select data-width="25%" name="roles[{{$member->id}}]" id="role{{$member->id}}"
                                                class="form-control w-25 member-role-select custom-select"
                                                data-placeholder="Select Member Role">
                                            @foreach($roles as $key=>$value)
                                                <option
                                                    {{isset($member->pivot->role) && $member->pivot->role==$key ? "selected" : ""}} value="{{$key}}">{{__($value)}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="badge badge-primary badge-lg ml-2">{{$member->fullName}}</span>
                                    @endcan
                                </li>
                            @endforeach
                        </ul>
                        <div class="form-group d-flex justify-content-between align-items-center mt-5">
                            @can('viewAny', App\Models\Team::class)
                                <a href="{{route('teams.index')}}"
                                   class="btn btn-outline-primary">{{__('Back To List')}}</a>
                            @endcan
                            @can('update', $team)
                                <a href="{{route('teams.edit',['team'=>$team->id])}}"
                                   class="btn btn-info">{{__('Edit Team')}}</a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection