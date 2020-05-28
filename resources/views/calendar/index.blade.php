@extends('layouts.dashboard')

@section('title','Calendar')

@section('content')
    <form action="{{route('calendar.settings.update', [$employee])}}" method="post" id="calendarSettingsForm">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label for="assigned_tasks_color">Assigned Tasks</label>
                <input type="color" id="assigned_tasks_color" name="assigned_tasks_color"
                       value="{{ $employee->calendarSettings->assigned_tasks_color }}">
            </div>
            <div class="col-md-3">
                <label for="created_tasks_color">Created Tasks</label>
                <input type="color" id="created_tasks_color" name="created_tasks_color"
                       value="{{ $employee->calendarSettings->created_tasks_color }}">
            </div>
        </div>
    </form>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendar" class="fc fc-ltr fc-unthemed"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        let calendar = new Calendar(document.getElementById('calendar'), {
            plugins: [dayGridPlugin],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            // height: "auto",
            aspectRatio: 2,
            firstDay: 1,
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: [
                    @foreach($employee->assignedTasks as $task)
                {
                    title: '{{$task->title}}',
                    start: new Date('{{ date('M d Y H:i:s', strtotime($task->deadline)) }}'),
                    color: '{{ $employee->calendarSettings->assigned_tasks_color }}',
                    url: '{{ 'tasks/' . $task->id . '/edit' }}',
                    textColor: 'white',
                },
                    @endforeach
                    @foreach($employee->createdTasks as $task)
                {
                    title: '{{$task->title}}',
                    start: new Date('{{ date('M d Y H:i:s', strtotime($task->deadline)) }}'),
                    color: '{{ $employee->calendarSettings->created_tasks_color }}',
                    url: '{{ 'tasks/' . $task->id . '/edit' }}',
                    textColor: 'white',
                },
                @endforeach
            ],
            eventClick: function (event) {
                if (event.url) {
                    window.open(event.url, "_blank");
                    return false;
                }
            }
        });

        calendar.render();

        $('#assigned_tasks_color, #created_tasks_color').change(function (e) {
            $('#calendarSettingsForm').submit();
        })
    </script>
@endpush
@push('style')
    <link href="{{ asset('css/full_calendar.css') }}" rel="stylesheet">
@endpush