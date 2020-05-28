@extends('layouts.dashboard')

@section('title','Time Offs')

@section('content')
    <div class="row mt-3">
        <div class="col-6">
            <h5 class="d-flex mb-2 justify-content-between">{{__('You have:')}}
                <span
                    class="badge badge-primary badge-lg">{{Auth::user()->employee->paid_time}} {{__('paid days')}}</span>
            </h5>
            <h5 class="d-flex mb-2 justify-content-between">{{__('You spent:')}}
                <span
                    class="badge badge-primary badge-lg">{{Auth::user()->employee->unpaid_time}} {{__('unpaid days')}}</span>
            </h5>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-end align-items-center">
                <button data-toggle="modal" data-target="#createTimeOffModal"
                        class="btn btn-primary">{{__('Request a Time-Off')}}</button>
            </div>
        </div>
    </div>
    @if (!empty($errors))
        <div class="d-flex flex-column justify-content-end align-items-center">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    {{__($error)}}
                    <button type="button" class="close text-light" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        </div>
    @endif
    <table class="table table-light">
        <thead class="table-primary">
        <tr>
            <th>{{__('Type')}}</th>
            <th>{{__('Paid')}}</th>
            <th class="cut-content">{{__('Reason')}}</th>
            <th>{{__('From')}}</th>
            <th>{{__('To')}}</th>
            <th class="text-center">{{__('Approved')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($timeOffs as $timeOff)
            <tr>
                <td>{{__($types[$timeOff->type])}}</td>
                <td>
                    <span @if ($timeOff->paid)
                          title="{{__('Paid')}}"
                          class="badge badge-success badge-lg"
                          @else
                          title="{{__('Unpaid')}}"
                          class="badge badge-secondary badge-lg"
                        @endif >
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                </td>
                <td class="cut-content" data-toggle="tooltip" title="{{$timeOff->reason}}">{{$timeOff->reason}}</td>
                <td>{{$timeOff->started_at->hour==0&&$timeOff->started_at->minute==0?$timeOff->started_at->format('d.m.Y'):$timeOff->started_at->format('H:i d.m.Y')}}</td>
                <td>{{$timeOff->finished_at->hour==0&&$timeOff->finished_at->minute==0?$timeOff->finished_at->format('d.m.Y'):$timeOff->finished_at->format('H:i d.m.Y')}}</td>
                <td class="text-center">
                    <span @if ($timeOff->approved)
                          title="{{__('Approved')}}"
                          class="badge badge-success badge-lg"
                          @else
                          title="{{__('Unapproved')}}"
                          class="badge badge-secondary badge-lg"
                        @endif >
                        <i class="fas fa-check"></i>
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6"><p class="text-center">{{__('You don\'t have any time-offs submitted')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @unless(empty($timeOffs))
        <div aria-label="Page navigation" class="mt-4 d-flex justify-content-center">
            {{$timeOffs->onEachSide(4)->links()}}
        </div>
    @endunless

    <!-- Modal -->
    <div class="modal fade" id="createTimeOffModal" role="dialog"
         aria-labelledby="createTimeOffModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTimeOffModalLongTitle">{{__('Create new TimeOff')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{route('time-offs.store')}}" method="post"
                      class="modal-body"
                      id="createTimeOffModalForm">
                    @csrf
                    @include('time_offs.form')
                </form>
                <div class="modal-footer">
                    <button type="reset" form="createTimeOffModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="createTimeOffModalForm"
                            class="btn btn-primary">{{__('Submit')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            $('#type').on('change', function () {
                let type = $(this).val(),
                    displayClass = '';
                switch (type) {
                    case 'day_off':
                        displayClass = 'day-off';
                        break;
                    case 'vacation':
                        displayClass = 'vacation';
                        break;
                    default:
                        displayClass = 'other-types';
                        break;
                }
                $('.date-input').addClass('d-none').find('input').prop('required', false);
                $(`.${displayClass}`).removeClass('d-none').find('input').prop('required', true);
            });
            $('#vacation').on('change', function () {
                let dates = $(this).val().split(' to ');
                $('#started_at').val(dates[0]).change();
                $('#finished_at').val(dates[1] || dates[0]).change();
            });
            $('#day_off').on('change', function () {
                $('#started_at').val($(this).val()).change();
                $('#finished_at').val($(this).val()).change();
            });
            $('#started_at').on('change', function () {
                let fp = $('#finished_at')[0]._flatpickr;
                fp.set('minDate', $(this).val());
            });
        })
    </script>
@endpush