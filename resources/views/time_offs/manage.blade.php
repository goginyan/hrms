@extends('layouts.dashboard')

@section('title','Manage Time-Offs')

@section('content')
    <form action="{{route('time-offs.update')}}" method="post" class="row mb-3">
        @csrf
        @method('put')
        <div class="col-6">
            <div class="form-group m-0 d-flex justify-content-between align-items-center">
                <label for="expire">{{__('Paid time expire on:')}}</label>
                <input id="expire" name="expire_date" value="{{$expireDate??""}}" class="form-control w-50"
                       data-type="datetime" data-min-date="today">
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-end align-items-center">
                <button class="btn btn-primary">{{__('Update')}}</button>
            </div>
        </div>
    </form>
    <table class="table table-light">
        <thead class="table-primary">
        <tr>
            <th>{{__('Employee')}}</th>
            <th>{{__('Type')}}</th>
            <th>{{__('Paid')}}</th>
            <th class="cut-content">{{__('Reason')}}</th>
            <th>{{__('From')}}</th>
            <th>{{__('To')}}</th>
            <th class="text-center">{{__('Approved')}}</th>
            <th>{{__('Delete')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($timeOffs as $timeOff)
            <tr>
                <td>{{$timeOff->employee->fullName}}</td>
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
                <td>{{$timeOff->started_at->hour==0 && $timeOff->started_at->minute==0 ? $timeOff->started_at->format('d.m.Y') : $timeOff->started_at->format('H:i d.m.Y')}}</td>
                <td>{{$timeOff->finished_at->hour==0 && $timeOff->finished_at->minute==0 ? $timeOff->finished_at->format('d.m.Y') : $timeOff->finished_at->format('H:i d.m.Y')}}</td>
                <td class="text-center">
                    @if ($timeOff->approved)
                        <span title="{{__('Approved')}}" class="badge badge-success badge-lg">
                            <i class="fas fa-check"></i>
                        </span>
                    @else
                        <a href="{{route('time-offs.approve',$timeOff)}}"
                           class="btn btn-sm btn-circle btn-success"><i class="fas fa-check"></i></a>
                    @endif
                </td>
                <td>
                    <form id="destroyTimeOff{{$timeOff->id}}"
                          action="{{route('time-offs.destroy', $timeOff)}}"
                          method="post">
                        @csrf
                        @method('delete')
                    </form>
                    <button title="Remove" type="submit" form="destroyTimeOff{{$timeOff->id}}"
                            class="btn btn-sm btn-circle btn-danger destroy-btn">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"><p class="text-center">{{__('There are not any time-offs submitted')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @unless(empty($timeOffs))
        <div aria-label="Page navigation" class="mt-4 d-flex justify-content-center">
            {{$timeOffs->onEachSide(5)->links()}}
        </div>
    @endunless
@endsection