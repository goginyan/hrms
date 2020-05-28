@extends('layouts.dashboard')

@section('title',__('Timesheet'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-group m-0">
            <input class="form-control bg-light" id="timesheetRange"
                   data-type="daterange" data-default-range="{{$from}},{{$to??""}}"
                   placeholder="{{__('Select range of date')}}">
        </div>
        <form id="dateRangeForm" action="{{route('time-sheet')}}">
            @csrf
            <input type="hidden" name="from" id="dateFrom">
            <input type="hidden" name="to" id="dateTo">
        </form>
        <button data-toggle="modal" id="addRowBtn" data-target="#addItemModal"
                class="btn btn-primary">{{__('Add row')}}</button>
    </div>
    <table class="table table-bordered table-light timesheet-table">
        <thead class="table-primary">
        <tr>
            <th class="w-25">{{__('Task')}}</th>
            <th>{{__('Comment')}}</th>
            <th class="w-15 text-center">{{__('Time')}}</th>
            <th class="w-15">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($days as $day => $items)
            @foreach($items as $item)
                <tr>
                    <td>
                        @if ($item->task)
                            <a href="{{route('tasks.edit',$item->task)}}">{{$item->task->title}}</a>
                        @else
                            <span>{{__('No task')}}</span>
                        @endif
                    </td>
                    <td>
                        <span class="cut-content">
                            {{$item->comment??__('No comment')}}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="duration" data-duration="{{$item->duration}}"
                              id="item{{$item->id}}">{{$item->humanDuration}}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-evenly">
                            <button data-url="{{route('time-trackers.update', $item)}}"
                                    data-task="{{$item->task->id??0}}"
                                    title="{{__('Edit')}}" data-toggle="modal" data-target="#editItemModal"
                                    class="btn btn-sm btn-circle btn-outline-primary stop-timer">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button data-url="{{route('time-trackers.destroy', $item)}}" title="{{__('Delete row')}}"
                                    type="button"
                                    class="btn btn-sm btn-circle btn-danger destroy-btn">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr class="table-info">
                <td colspan="2" class="text-center">{{$day}}</td>
                <td class="text-center">{{$durations[$day]}}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
        @unset($item)
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editItemModal" role="dialog"
         aria-labelledby="editItemModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLongTitle">{{__('Edit Row')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" class="modal-body"
                      id="editItemModalForm">
                    @csrf
                    @method('PUT')
                    @include('tracker.form', ['fields'=>[
                        'task'=>'',
                        'comment'=>'required',
                        'duration'=>'required',
                    ]])
                </form>
                <div class="modal-footer">
                    <button type="reset" form="editItemModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="editItemModalForm" id="editItemSave"
                            class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addItemModal" role="dialog"
         aria-labelledby="addItemModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLongTitle">{{__('Add Row')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('time-trackers.store')}}" method="post" class="modal-body"
                      id="addItemModalForm">
                    @csrf
                    @include('tracker.form', ['fields'=>[
                        'task'=>'',
                        'comment'=>'required',
                        'duration'=>'required',
                        'date'=>'required'
                    ]])
                </form>
                <div class="modal-footer">
                    <button type="reset" form="addItemModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="addItemModalForm" id="addItemSave"
                            class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function loading(active = true) {
            $('.timesheet-table tbody, #addRowBtn').css({
                opacity: active ? 0.5 : '',
                pointerEvents: active ? 'none' : ''
            })
        }

        $(function () {
            $('#editItemModal').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget), // Button that triggered the modal
                    url = button.data('url'),
                    task = button.data('task'),
                    comment = button.parents('tr').find('.cut-content').text().trim(),
                    duration = button.parents('tr').find('.duration').attr('data-duration');// Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                let modal = $(this);
                modal.find('#editItemModalForm').attr('action', url);
                modal.find('select').val(task).change();
                modal.find('textarea').val(comment);
                modal.find('#duration').val(duration);

            });
            $('#timesheetRange').on('change', function () {
                let dates = $(this).val().split(' to ');
                $('#dateFrom').val(dates[0]);
                if (dates.length > 0) {
                    $('#dateTo').val(dates[1]);
                }
                $('#dateRangeForm').submit();
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
        })
    </script>
@endpush
