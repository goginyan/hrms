@extends('layouts.dashboard')

@section('title','Reports')

@section('content')
    <div class="d-flex justify-content-end reports-search">
        <div class="d-inline-flex w-25 flex-column">
            <div class="form-group">
                <input placeholder="{{__('Search')}}" autocomplete="off" class="form-control" type="text" name="search"
                       id="search" data-url="{{route('reports.search')}}">
            </div>
            <ul class="results-list list-group" style="display: none;"></ul>
        </div>
    </div>
    @can('view reports')
        <ul class="list-group list-group-flush reports-list">
            @foreach($reports as $report)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{route('reports.show', $report)}}">
                        {{$report->title}}
                    </a>
                    @if ($report->has_chart)
                        <i class="fas fa-chart-pie text-primary"></i>
                    @endif
                    @if ($report->survey)
                        <i class="fas fa-question text-primary"></i>
                    @endif
                </li>
            @endforeach
        </ul>
    @endcan
@endsection