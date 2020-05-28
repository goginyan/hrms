@extends('layouts.dashboard')

@section('title',__('Profile'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-3">
                @include('profile.profile_top')
                <div class="card-body">
                    <h4 class="card-title">{{__('Personal Information')}}</h4>
                    @forelse($fields as $field)
                        @continue($field->protected)
                        <div class="row p-3 border-bottom">
                            <div class="col-3 border-right">
                                <h5 class="m-0">{{__($field->label)}}</h5>
                            </div>
                            @switch($field->column)
                                @case('experience')
                                <div class="col-9">
                                    <table class="table">
                                        <thead class="table-primary">
                                        <tr>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Position')}}</th>
                                            <th>{{__('Description')}}</th>
                                            <th>{{__('From')}}</th>
                                            <th>{{__('To')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($employee->experiences as $experience)
                                            <tr>
                                                <td>{{$experience->name}}</td>
                                                <td>{{$experience->position}}</td>
                                                <td>{{$experience->description??""}}</td>
                                                <td>{{$experience->date_from}}</td>
                                                <td>{{$experience->date_to??__('Until today')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @break
                                @case('education')
                                <div class="col-9">
                                    <table class="table">
                                        <thead class="table-primary">
                                        <tr>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Department')}}</th>
                                            <th>{{__('Specialization')}}</th>
                                            <th>{{__('Degree')}}</th>
                                            <th>{{__('From')}}</th>
                                            <th>{{__('To')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($employee->educations as $education)
                                            <tr>
                                                <td>{{$education->name}}</td>
                                                <td>{{$education->department??""}}</td>
                                                <td>{{$education->specialization}}</td>
                                                <td>{{__($degrees[$education->degree]??"")}}</td>
                                                <td>{{$education->date_from}}</td>
                                                <td>{{$education->date_to??__('Until today')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @break
                                @default
                                <div class="col-auto">
                                    <h5 class="m-0">{{ $field->column
                                    ? $employee->getAttribute($field->column)
                                    : $employee->profileFormFields()->where('profile_form_field_id',$field->id)->first()->pivot->data
                                    }}
                                    </h5>
                                </div>
                                @break
                            @endswitch
                        </div>
                    @empty
                        <p>{{__('There is no public information')}}</p>
                    @endforelse
                </div>
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <a href="{{route('profile.edit')}}" class="btn btn-primary">{{__('Edit Profile')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
