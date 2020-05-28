@extends('layouts.dashboard')

@section('title','Candidates Interviews')

@section('content')
    <table class="table table-sm table-bordered interviews-table">
        <thead class="table-primary">
        <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('Planned At')}}</th>
            <th>{{__('Position')}}</th>
            <th>{{__('Organizer')}}</th>
            <th>{{__('Candidate Name')}}</th>
            <th>{{__('Candidate Email')}}</th>
            <th class="text-center">{{__('Status')}}</th>
            <th class="text-center">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($interviews as $interview)
            <tr class="{{$interview->status==='pending'?'table-warning': ($interview->status === 'done' ? 'table-secondary' : (now()->diffInHours($interview->planned_at) <= 1 ? 'table-success' : ''))}}">
                <td>{{$interview->id}}</td>
                <td>{{$interview->planned_at->format('d.m.Y H:i')}}</td>
                <td>{{$interview->vacancy->position}}</td>
                <td>{{$interview->organizer->fullName}}</td>
                <td>
                    <a href="{{route('applicants.show',$interview->applicant)}}">{{$interview->applicant->first_name??__("No Name")}}</a>
                </td>
                <td><a target="_blank"
                       href="mailto:{{$interview->applicant->email??'#'}}">{{$interview->applicant->email??__("No Email")}}</a>
                </td>
                <td class="text-center">
                    <select data-url="{{route('interviews.update',$interview)}}" class="form-control status-select"
                            id="interviewStatus{{$interview->id}}">
                        @foreach($statuses as $key => $value)
                            <option {{$key==$interview->status?"selected":""}} value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="text-center">
                    <a class="mr-3" href="{{route('interviews.show',$interview)}}">{{__('View')}}</a>
                    <a href="{{route('interviews.edit',$interview)}}">{{__('Edit')}}</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"><p class="text-center">{{__('There are not any interviews registered')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <button {{$vacancies->count()==0?"disabled":""}} data-toggle="modal" data-target="#createInterviewModal"
                class="btn btn-primary">{{__('Plan New')}}</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createInterviewModal" role="dialog" aria-labelledby="createInterviewModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createInterviewModalLongTitle">{{__('Plan new Interview')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('interviews.create')}}" method="get" class="modal-body"
                      id="createInterviewModalForm">
                    @csrf
                    <div class="form-group">
                        <label for="vacancy">{{__('For which vacancy')}}</label>
                        <select name="vacancy" id="vacancy" class="form-control custom-select" data-width="100%">
                            <option value="">{{__('Select Job Position')}}</option>
                            @foreach($vacancies as $vacancy)
                                <option value="{{$vacancy->id}}">{{$vacancy->position}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="reset" form="createInterviewModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="createInterviewModalForm"
                            class="btn btn-primary">{{__('Create')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection