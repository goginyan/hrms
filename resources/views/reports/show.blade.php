@extends('layouts.dashboard')

@section('title',$report->title)

@section('content')
    @if ($report->has_chart)
        <div id="chartsContainer" class="mb-4"></div>
    @endif
    <form id="filtersForm" action="{{route('reports.show',$report)}}" class="row align-items-baseline">
        <div class="form-group d-flex flex-column col-12 col-sm-6 col-md-3">
            <label for="filtered">{{__('Filtered Count:')}}</label>
            <input type="number" readonly disabled class="form-control w-50 text-center" id="filtered"
                   value="{{count($employees)}}">
        </div>
        <div class="form-group d-flex flex-column col-12 col-sm-6 col-md-3">
            <label for="department">{{__('Department')}}</label>
            <select name="department" id="department" data-width="100%" class="form-control custom-select">
                <option value="" selected>{{__('All')}}</option>
                @foreach($departments as $dep)
                    <option value="{{$dep->id}}">{{$dep->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group d-flex flex-column col-12 col-sm-6 col-md-3">
            <label for="role">{{__('Job Title')}}</label>
            <select name="role" id="role" data-width="100%" class="form-control custom-select">
                <option value="" selected>{{__('All')}}</option>
                @foreach($roles as $r)
                    @continue($r->name === 'root')
                    <option value="{{$r->name}}">{{$r->display_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group d-flex flex-column col-12 col-sm-6 col-md-3">
            <label for="status">{{__('Employment Status')}}</label>
            <select name="status" id="status" data-width="100%" class="form-control custom-select">
                <option value="" selected>{{__('All')}}</option>
                @foreach($statuses as $key=>$value)
                    <option value="{{$key}}">{{__($value)}}</option>
                @endforeach
            </select>
        </div>
    </form>
    <table id="reportsTable" class="table table-sm table-bordered employees-table" data-ordering="{{$report->ordering}}"
           data-category="{{$report->order_column}}">
        <thead class="table-primary">
        <tr>
            @foreach($report->fields as $field)
                @if (is_array($field))
                    <th class="{{$report->order_column==$field['text']?'order-by':''}}">{{__(ucwords(implode(' ', preg_split('/(?=[A-Z])/', $field['text']))))}}</th>
                @else
                    <th class="{{$report->order_column==$field?'order-by':''}}">{{__(ucwords(implode(' ', preg_split('/(?=[A-Z])/', $field))))}}</th>
                @endif
            @endforeach
        </tr>
        </thead>
        <tbody class="table-hover">
        @forelse ($employees as $employee)
            <tr>
                @foreach($employee as $field)
                    <td>{{$field}}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="12"><p class="text-center">{{__('There are not any employees registered')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex table-actions align-items-center justify-content-end">
        <span id="buttons"></span>
    </div>

    <div class="form-group d-flex align-items-center mt-5">
        @can('view reports')
            <a href="{{route('reports.index')}}"
               class="btn btn-outline-primary">{{__('Back To List')}}</a>
        @endcan
    </div>
@endsection

@push('script')
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css"/>
    <script src="//www.amcharts.com/lib/4/core.js"></script>
    <script src="//www.amcharts.com/lib/4/charts.js"></script>
    <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>
    <script>
        let reportData = JSON.parse(`{!! $reportJson !!}`);
    </script>
    <script src="{{asset('js/reports.js')}}"></script>
@endpush