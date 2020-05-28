@extends('layouts.dashboard')

@section('title','Payroll')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @foreach($months as $month)
                        <div>
                            <a href="{{route('payroll.show', $month)}}">{{$month['month']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection