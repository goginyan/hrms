@extends('layouts.dashboard')

@section('title','Bonuses')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{route('bonuses.create')}}" class="btn btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bonuses as $bonus)
                                <tr>
                                    <td>{{$bonus->name}}</td>
                                    <td>
                                        <form id="destroyBonus{{$bonus->id}}"
                                              action="{{route('bonuses.destroy', ['bonus'=>$bonus->id])}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a class="btn-link mx-4"
                                               href="{{route('bonuses.edit',['bonus'=>$bonus->id])}}">View</a>
                                            <button title="Delete Bonus" type="submit" form="destroyBonus{{$bonus->id}}"
                                                    class="btn btn-link text-danger destroy-btn mx-4">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection