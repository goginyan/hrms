@extends('layouts.dashboard')

@section('title',__('Time Trackers'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{__('Today')}} - {{today()->format('d.m.Y')}}</h3>
        <button data-toggle="modal" id="createTrackerBtn" data-target="#createTrackerModal"
                class="btn btn-primary">{{__('Create Tracker')}}</button>
    </div>
    <table class="table table-bordered table-light trackers-table">
        <thead class="table-primary">
        <tr>
            <th class="w-50">{{__('Task/Comment')}}</th>
            <th class="w-15 text-center">{{__('Time')}}</th>
            <th class="w-15">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody class="table-hover">
        @foreach($trackers as $tracker)
            <tr>
                <td>
                    @if ($tracker->task)
                        <a data-toggle="tooltip" title="{{$tracker->comment}}"
                           href="{{route('tasks.edit',$tracker->task)}}">{{$tracker->task->title}}</a>
                    @else
                        <span>{{$tracker->comment}}</span>
                    @endif
                </td>
                <td class="text-center">
                    <span @if($tracker->finished_at) data-finished="{{$tracker->duration}}"
                          @endif id="tracker{{$tracker->id}}"
                          data-id="{{$tracker->id}}"
                          data-time="{{$tracker->created_at->format('U')}}"
                          class="time-tracker">00:00:00</span>
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-evenly">
                        <button @if($tracker->finished_at) disabled
                                @endif data-url="{{route('time-trackers.update', $tracker)}}"
                                title="{{__('Stop tracker')}}"
                                class="btn btn-sm btn-circle btn-secondary stop-timer"><i
                                class="fas fa-stop"></i>
                        </button>
                        <button data-url="{{route('time-trackers.destroy', $tracker)}}" title="{{__('Delete Tracker')}}"
                                type="button"
                                class="btn btn-sm btn-circle btn-danger destroy-btn">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
        @unset($tracker)
    </table>

    <!-- Modal -->
    <div class="modal fade" id="createTrackerModal" role="dialog"
         aria-labelledby="createTrackerModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTrackerModalLongTitle">{{__('Create new Tracker')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('time-trackers.store')}}" method="post" class="modal-body"
                      id="createTrackerModalForm">
                    @csrf
                    @include('tracker.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="createTrackerModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="button" data-dismiss="modal" id="createNewTracker" form="createTrackerModalForm"
                            class="btn btn-primary">{{__('Start')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        let trackers = {};

        function startTracking(id) {
            let tracker = $(`#tracker${id}`);
            let now = Date.now() / 1000;
            let startValues = {seconds: now.toFixed() - +tracker.attr('data-time')};
            trackers[id] = new Timer();
            trackers[id].start({precision: 'seconds', startValues});
            tracker.html(trackers[id].getTimeValues().toString());
            if (tracker.attr('data-finished')) {
                let duration = +tracker.attr('data-finished'),
                    minutes = duration % 60,
                    hours = (duration - minutes) / 60;
                tracker.html(`${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:00`);
            } else {
                trackers[id].addEventListener('secondsUpdated', function (e) {
                    tracker.html(trackers[id].getTimeValues().toString())
                });
            }
        }

        function loading(start = true) {
            $('.trackers-table tbody, #createTrackerBtn').css({
                opacity: start ? 0.5 : '',
                pointerEvents: start ? 'none' : ''
            });
        }

        $(function () {
            $('.time-tracker').each(function () {
                let id = $(this).attr('data-id');
                startTracking(id);
            });
            $('#createNewTracker').on('click', function () {
                let table = $('.trackers-table tbody'),
                    form = $(this).attr('form'),
                    url = $(`#${form}`).attr('action'),
                    task = $('#task');
                if (!task.val()) {
                    task.parent().find('.invalid-feedback').addClass('d-block').text('Task field is required');
                    return false;
                }
                loading();
                axios.post(url, {
                    task_id: task.val(),
                    comment: $('#comment').val()
                }).then(({data}) => {
                    loading(false);
                    let tracker = $(
                        `<tr>
                            <td><a data-toggle="tooltip" title="${data.tracker.comment}" href="{{route('tasks.index')}}/${data.task.id}">${data.task.title}</a></td>
                            <td class="text-center">
                                 <span id="tracker${data.tracker.id}" data-id="${data.tracker.id}" data-time="${Date.now() / 1000}" class="time-tracker">00:00:00</span>
                            </td>
                            <td>
                                 <div class="d-flex align-items-center justify-content-evenly">
                                     <button data-url="{{route('time-trackers.index')}}/${data.tracker.id}" title="{{__('Stop tracker')}}" class="btn btn-sm btn-circle btn-secondary stop-timer"><i class="fas fa-stop"></i>
                                     </button>
                                     <button data-url="{{route('time-trackers.index')}}/${data.tracker.id}" title="{{__('Delete Tracker')}}" type="button"
                                             class="btn btn-sm btn-circle btn-danger destroy-btn">
                                         <i class="fa fa-times"></i>
                                     </button>
                                 </div>
                            </td>
                        </tr>`
                    );
                    table.append(tracker);
                    $('[data-toggle="tooltip"]').tooltip();
                    $(`#${form}`).find('select, textarea').val('').change();
                    startTracking(data.tracker.id);
                }).catch(error => {
                    alert(error);
                    location.reload();
                })
            });
            $(document).on('click', '.destroy-btn', function () {
                let url = $(this).attr('data-url');
                let _this = $(this);
                loading();
                axios.delete(url, {})
                    .then(response => {
                        _this.parents('tr').remove();
                        loading(false);
                    })
                    .catch(error => {
                        alert(error);
                        location.reload();
                    })
            });
            $(document).on('click', '.stop-timer', function () {
                let _this = $(this);
                let tracker = $(this).parents('tr').find('.time-tracker');
                let id = tracker.attr('data-id');
                let url = $(this).attr('data-url');
                loading();
                axios.put(url, {
                    finished_at: trackers[id].getTimeValues().toString()
                }).then(response => {
                    loading(false);
                    trackers[id].stop();
                    _this.prop('disabled', true);
                }).catch(error => {
                    alert(error);
                    location.reload();
                });
            })
        })
    </script>
@endpush