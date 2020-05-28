@extends('layouts.dashboard')

@section('title','Non Taxable Income')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('non_taxable_income.update', compact('non_taxable_income'))}}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   value="{{ $non_taxable_income->name }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback d-block">
                                    {{$errors->first('name')}}
                                </div>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection