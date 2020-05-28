@extends('layouts.dashboard')

@section('title','Non Taxable Incomes')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{route('non_taxable_income.create')}}" class="btn btn-primary">Add New</a>
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
                            @foreach($non_taxable_incomes as $non_taxable_income)
                                <tr>
                                    <td>{{$non_taxable_income->name}}</td>
                                    <td>
                                        <form id="destroyIncome{{$non_taxable_income->id}}"
                                              action="{{route('non_taxable_income.destroy', compact('non_taxable_income'))}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a class="btn-link mx-4"
                                               href="{{route('non_taxable_income.edit', compact('non_taxable_income'))}}">View</a>
                                            <button title="Delete Non Taxable Income" type="submit"
                                                    form="destroyIncome{{$non_taxable_income->id}}"
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