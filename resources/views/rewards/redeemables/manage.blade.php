@extends('layouts.dashboard')

@section('title',__('Redeemed Products(Services)'))

@section('content')
    <table class="table table-sm table-bordered redeemables-table">
        <thead class="table-primary">
        <tr>
            <th>{{__('Title')}}</th>
            <th class="text-center">{{__('Price')}}</th>
            <th>{{__('Owner')}}</th>
            <th>{{__('Redeemed At')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($redeemables as $redeemable)
            @foreach($redeemable->employees as $employee)
                <tr>
                    <td><a class="mr-3" href="{{route('redeemables.show',$redeemable)}}">{{$redeemable->title}}</a></td>
                    <td class="text-center">{{$redeemable->price}} {{__('point(s)')}}</td>
                    <td>{{$employee->fullName}}</td>
                    <td>{{\Illuminate\Support\Carbon::parse($employee->pivot->date)->format('d.m.Y H:i')}}</td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="8"><p class="text-center">{{__('There are not any redeemables added')}}</p></td>
            </tr>
        @endforelse
        @unset($redeemable)
        </tbody>
    </table>
@endsection
