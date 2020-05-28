@extends('layouts.dashboard')

@section('title','Teams')

@section('content')
    <ul class="list-group list-group-flush">
        @can('viewAny', App\Models\Team::class)
            @foreach($teams as $team)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @can('view',$team)
                        <a href="{{route('teams.show', ['team'=>$team->id])}}">
                            {{$team->name}}
                            <span title="{{__('Team creator')}}"
                                  class="badge badge-secondary badge-lg ml-2">by {{$team->creator->first()->fullName??'Super Administrator'}}</span>
                        </a>
                    @else
                        <span>
                            {{$team->name}}
                            <span title="{{__('Team creator')}}"
                                  class="badge badge-secondary badge-lg ml-2">by {{$team->creator->first()->fullName??'Super Administrator'}}</span>
                        </span>
                    @endcan
                    @can('delete', $team)
                        <form id="destroyPerm{{$team->id}}"
                              action="{{route('teams.destroy', ['team'=>$team->id])}}"
                              method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <button title="Remove" type="submit" form="destroyPerm{{$team->id}}"
                                class="btn btn-sm btn-circle btn-danger destroy-btn">
                            <i class="fa fa-times"></i>
                        </button>
                    @endcan
                </li>
            @endforeach
        @endcan
    </ul>
    @can('create teams')
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('teams.create')}}" class="btn btn-primary">Create Team</a>
        </div>
    @endcan
@endsection
