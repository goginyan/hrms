@extends('layouts.dashboard')

@section('title',__('Quizzes Questions'))

@section('content')
    <table class="table table-sm table-bordered questions-table">
        <thead class="table-primary">
        <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('Title')}}</th>
            <th>{{__('Type')}}</th>
            <th>{{__('Question')}}</th>
            <th>{{__('Created At')}}</th>
            <th class="text-center">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($questions as $question)
            <tr>
                <td>{{$question->id}}</td>
                <td>{{$question->title}}</td>
                <td>{{$types[$question->type]}}</td>
                <td class="text-overflow">{{$question->text}}</td>
                <td>{{$question->created_at->format('d.m.Y H:i')}}</td>
                <td class="text-center">
                    <a class="mr-3" href="{{route('quiz.questions.show',$question)}}">{{__('View')}}</a>
                    <a href="{{route('quiz.questions.edit',$question)}}">{{__('Edit')}}</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"><p class="text-center">{{__('There are not any questions created')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <a href="{{route('quiz.questions.create')}}" class="btn btn-primary">{{__('Create New')}}</a>
    </div>
@endsection