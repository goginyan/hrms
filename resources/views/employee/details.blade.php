@extends('layouts.dashboard')

@section('title','Details of Employees')

@section('content')
    <table class="table table-sm table-bordered employees-table">
        <thead class="table-primary">
        <tr>
            <th class="chartable active" data-category="{{\Illuminate\Support\Str::camel('Id')}}">{{__('ID')}}</th>
            <th>{{__('Full Name')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Patronymic')}}">{{__('Patronymic')}}</th>
            <th class="chartable" data-category="{{\Illuminate\Support\Str::camel('Age')}}">{{__('Age')}}</th>
            <th class="chartable" data-category="{{\Illuminate\Support\Str::camel('Gender')}}">{{__('Gender')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Nationality')}}">{{__('Nationality')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Department')}}">{{__('Department')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Job Title')}}">{{__('Job Title')}}</th>
            <th class="chartable" data-category="{{\Illuminate\Support\Str::camel('Salary')}}">{{__('Salary')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Paid Time')}}">{{__('Paid Time')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Unpaid Time')}}">{{__('Unpaid Time')}}</th>
            <th class="chartable"
                data-category="{{\Illuminate\Support\Str::camel('Recruited')}}">{{__('Recruited')}}</th>
        </tr>
        </thead>
        <tbody class="table-hover">
        @forelse ($employees as $employee)
            <tr>
                <td><a href="{{route('employees.show',$employee)}}">{{$employee->id}}</a></td>
                <td>{{$employee->fullName}}</td>
                <td>{{$employee->patronymic}}</td>
                <td>{{$employee->age}}</td>
                <td>{{$employee->sex}}</td>
                <td>{{$employee->nationality}}</td>
                <td>{{$employee->department->name}}</td>
                <td>{{$employee->role}}</td>
                <td>{{$employee->currentSalary??0}}</td>
                <td>{{$employee->paid_time}}</td>
                <td>{{$employee->unpaid_time}}</td>
                <td>{{$employee->created_at->format('d.m.Y')}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="12"><p class="text-center">{{__('There are not any employees registered')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex table-actions align-items-center justify-content-end">
        <button title="Pie Chart" id="pieChart" class="btn btn-circle btn-outline-primary mr-3">
            <i class="fas fa-chart-pie"></i>
        </button>
        <button title="Line Chart" id="lineChart" class="btn btn-circle btn-outline-primary mr-3">
            <i class="fas fa-chart-line"></i>
        </button>
        <button title="Bar Chart" id="barChart" class="btn btn-circle btn-outline-primary mr-3">
            <i class="fas fa-chart-bar"></i>
        </button>
        <button title="Horizontal Bar Chart" id="bulletChart" class="btn btn-circle btn-outline-primary">
            <i class="fas fa-chart-bar"></i>
        </button>
    </div>
    <div id="chartsContainer" class="mt-4"></div>
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
        let employeesData = JSON.parse(`{!! $employeesJson !!}`);
    </script>
    <script src="{{asset('js/employees.js')}}"></script>
@endpush