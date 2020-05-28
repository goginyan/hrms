@extends('layouts.dashboard')

@section('title','Payroll')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" id="payroll-form">
                        @csrf
                        <label for="month">Choose Month</label>
                        <input type="month" name="month" id="month" class="form-control w-25" required>
                        <button class="btn btn-primary mt-4">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection