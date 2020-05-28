@extends('layouts.dashboard')

@section('title','Taxes')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{route('taxes.create')}}" class="btn btn-primary">Add New</a>
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
                            @foreach($taxes as $tax)
                                <tr>
                                    <td>{{$tax->name}}</td>
                                    <td>
                                        <form id="destroyTax{{$tax->id}}"
                                              action="{{route('taxes.destroy', ['tax'=>$tax->id])}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a class="btn-link mx-4"
                                               href="{{route('taxes.edit',['tax'=>$tax->id])}}">View</a>
                                            <button title="Delete Tax" type="submit" form="destroyTax{{$tax->id}}"
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