@extends('layouts.dashboard')

@section('title','Quizzes Reports')

@section('content')
    <table class="table table-sm table-bordered quizzes-table">
        <thead class="table-primary">
        <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('Title')}}</th>
            <th class="text-center">{{__('Active')}}</th>
            <th class="text-center">{{__('Employees')}}</th>
            <th class="text-center">{{__('Applicants')}}</th>
            <th>{{__('Created At')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($quizzes as $quiz)
            <tr>
                <td>
                    <a href="{{route('quizzes.show',$quiz)}}">{{$quiz->id}}</a>
                </td>
                <td>{{$quiz->title}}</td>
                <td class="text-center">
                    <span class="badge {{$quiz->active?'badge-success':'badge-secondary'}}">&nbsp;</span>
                </td>
                <td class="text-center">
                    <a href="{{route('quizzes.reports.show',[$quiz,'scope'=>'employees'])}}">{{$quiz->employees->count()}}</a>
                </td>
                <td class="text-center">
                    <a href="{{route('quizzes.reports.show',[$quiz,'scope'=>'applicants'])}}">{{$quiz->applicants->count()}}</a>
                </td>
                <td>{{$quiz->created_at->format('d.m.Y H:i')}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6"><p class="text-center">{{__('There are not any quizzes registered')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection