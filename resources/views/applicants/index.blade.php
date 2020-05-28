@extends('layouts.dashboard')

@section('title','Vacancies Applicants')

@section('content')
    <table class="table table-sm table-bordered employees-table">
        <thead class="table-primary">
        <tr>
            <th>{{__('Id')}}</th>
            <th>{{__('First Name')}}</th>
            <th>{{__('Last Name')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Job Title')}}</th>
            <th>{{__('Created At')}}</th>
            <th class="text-center">{{__('Status')}}</th>
            <th class="text-center">{{__('Actions')}}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($applicants as $applicant)
            <tr>
                <td>{{$applicant->id}}</td>
                <td>{{$applicant->first_name}}</td>
                <td>{{$applicant->last_name}}</td>
                <td>{{$applicant->email}}</td>
                <td>{{$applicant->vacancy->position}}</td>
                <td>{{$applicant->created_at->format('d.m.Y')}}</td>
                <td class="text-center">
                    <select data-url="{{route('applicants.update',$applicant)}}" class="form-control status-select"
                            id="applicantStatus{{$applicant->id}}">
                        @foreach($statuses as $key => $value)
                            <option {{$key==$applicant->status?"selected":""}} value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </td>
                <td class="text-center">
                    <a class="mr-3" href="{{route('applicants.show',$applicant)}}">{{__('View')}}</a>
                    <a href="{{route('applicants.edit',$applicant)}}">{{__('Edit')}}</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"><p class="text-center">{{__('There are not any applicants registered')}}</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <button {{$vacancies->count()==0?"disabled":""}} data-toggle="modal" data-target="#createApplicantModal"
                class="btn btn-primary">{{__('Add New')}}</button>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="createApplicantModal" role="dialog" aria-labelledby="createApplicantModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createApplicantModalLongTitle">{{__('Create new Applicant')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('applicants.create')}}" method="get" class="modal-body"
                      id="createApplicantModalForm">
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
                    <button type="reset" form="createApplicantModalForm" class="btn btn-outline-primary"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="createApplicantModalForm"
                            class="btn btn-primary">{{__('Create')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection