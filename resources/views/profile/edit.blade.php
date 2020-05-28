@extends('layouts.dashboard')

@section('title',__('Edit Profile'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-3">
                @include('profile.profile_top')
                <div class="card-body">
                    <h4 class="card-title">{{__('Personal Information')}}</h4>
                    <form id="employeeProfileForm" enctype="multipart/form-data" action="{{route('profile.update')}}"
                          method="post">
                        @csrf
                        @method('put')
                        @foreach ($fields as $field)
                            @continue($field->column=='avatar')
                            <div class="row p-3 border-bottom align-items-center">
                                <div class="col-3 border-right">
                                    <h5 class="m-0"><label class="m-0"
                                                           for="{{'profileField'.$field->id}}">{{__($field->label)}}</label>
                                    </h5>
                                </div>
                                @switch($field->column)
                                    @case('education')
                                    <div class="col-9 profile-edit-column education-column">
                                        <div class="d-flex justify-content-end align-items-center mb-3">
                                            <button type="button" id="addEducationBtn"
                                                    class="btn btn-primary">{{__('Add Education')}}</button>
                                        </div>
                                        <div class="d-none flex-wrap align-items-end" id="zeroEducation">
                                            <div class="form-group mr-3 mb-2">
                                                <label for="educationName0">{{__('Name')}}</label>
                                                <input type="text" id="educationName0" name="education_name[]"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="educationDepartment0">{{__('Department')}}</label>
                                                <input type="text" id="educationDepartment0"
                                                       name="education_department[]" class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="educationSpecialization0">{{__('Specialization')}}</label>
                                                <input type="text" id="educationSpecialization0"
                                                       name="education_specialization[]" class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="educationDegree0">{{__('Degree')}}</label>
                                                <select name="education_degree[]" id="educationDegree0"
                                                        class="form-control">
                                                    @foreach ($degrees as $key=>$value)
                                                        <option value="{{$key}}">{{__($value)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="educationDateFrom0">{{__('From')}}</label>
                                                <input data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                       id="educationDateFrom0" name="education_from[]"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="educationDateTo0">{{__('To')}}</label>
                                                <input data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                       id="educationDateTo0" name="education_to[]"
                                                       class="form-control date-to">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <button type="button"
                                                        class="btn btn-danger remove-education-btn">{{__('Remove Education')}}</button>
                                            </div>
                                        </div>
                                        @foreach ($employee->educations as $education)
                                            <div class="d-flex flex-wrap align-items-end">
                                                <div class="form-group mr-3 mb-2">
                                                    <label for="educationName{{$education->id}}">{{__('Name')}}</label>
                                                    <input required value="{{$education->name}}" type="text"
                                                           id="educationName{{$education->id}}"
                                                           name="education_name[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="educationDepartment{{$education->id}}">{{__('Department')}}</label>
                                                    <input value="{{$education->department}}" type="text"
                                                           id="educationDepartment{{$education->id}}"
                                                           name="education_department[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="educationSpecialization{{$education->id}}">{{__('Specialization')}}</label>
                                                    <input required value="{{$education->specialization}}" type="text"
                                                           id="educationSpecialization{{$education->id}}"
                                                           name="education_specialization[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="educationDegree{{$education->id}}">{{__('Degree')}}</label>
                                                    <select name="education_degree[]"
                                                            id="educationDegree{{$education->id}}" class="form-control">
                                                        @foreach ($degrees as $key=>$value)
                                                            <option
                                                                {{$education->degree==$key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="educationDateFrom{{$education->id}}">{{__('From')}}</label>
                                                    <input required
                                                           value="{{$education->date_from}}"
                                                           data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                           id="educationDateFrom{{$education->id}}"
                                                           name="education_from[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label for="educationDateTo{{$education->id}}">{{__('To')}}</label>
                                                    <input value="{{$education->date_to??""}}"
                                                           data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                           id="educationDateTo{{$education->id}}"
                                                           name="education_to[]" class="form-control date-to">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <button type="button"
                                                            class="btn btn-danger remove-education-btn">{{__('Remove Education')}}</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @break
                                    @case('experience')
                                    <div class="col-9 profile-edit-column experience-column">
                                        <div class="d-flex justify-content-end align-items-center mb-3">
                                            <button type="button" id="addExperienceBtn"
                                                    class="btn btn-primary">{{__('Add Experience')}}</button>
                                        </div>
                                        <div class="d-none flex-wrap align-items-end" id="zeroExperience">
                                            <div class="form-group mr-3 mb-2">
                                                <label for="experienceName0">{{__('Name')}}</label>
                                                <input type="text" id="experienceName0" name="experience_name[]"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="experiencePosition0">{{__('Position')}}</label>
                                                <input type="text" id="experiencePosition0"
                                                       name="experience_position[]" class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="experienceDescription0">{{__('Description')}}</label>
                                                <input type="text" id="experienceDescription0"
                                                       name="experience_description[]" class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="experienceDateFrom0">{{__('From')}}</label>
                                                <input data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                       id="experienceDateFrom0" name="experience_from[]"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <label for="experienceDateTo0">{{__('To')}}</label>
                                                <input data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                       id="experienceDateTo0" name="experience_to[]"
                                                       class="form-control date-to">
                                            </div>
                                            <div class="form-group mr-3 mb-2">
                                                <button type="button"
                                                        class="btn btn-danger remove-experience-btn">{{__('Remove Experience')}}</button>
                                            </div>
                                        </div>
                                        @foreach ($employee->experiences as $experience)
                                            <div class="d-flex flex-wrap align-items-end">
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="experienceName{{$experience->id}}">{{__('Name')}}</label>
                                                    <input required value="{{$experience->name}}" type="text"
                                                           id="experienceName{{$experience->id}}"
                                                           name="experience_name[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="experiencePosition{{$experience->id}}">{{__('Position')}}</label>
                                                    <input required value="{{$experience->position}}" type="text"
                                                           id="experiencePosition{{$experience->id}}"
                                                           name="experience_position[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="experienceDescription{{$experience->id}}">{{__('Description')}}</label>
                                                    <input value="{{$experience->description}}" type="text"
                                                           id="experienceDescription{{$experience->id}}"
                                                           name="experience_description[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="experienceDateFrom{{$experience->id}}">{{__('From')}}</label>
                                                    <input required
                                                           value="{{$experience->date_from}}"
                                                           data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                           id="experienceDateFrom{{$experience->id}}"
                                                           name="experience_from[]" class="form-control">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <label
                                                        for="experienceDateTo{{$experience->id}}">{{__('To')}}</label>
                                                    <input value="{{$experience->date_to??""}}"
                                                           data-type="date" autocomplete="off" placeholder="dd.mm.yyyy"
                                                           id="experienceDateTo{{$experience->id}}"
                                                           name="experience_to[]" class="form-control date-to">
                                                </div>
                                                <div class="form-group mr-3 mb-2">
                                                    <button type="button"
                                                            class="btn btn-danger remove-experience-btn">{{__('Remove Experience')}}</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @break
                                    @case('citizenship')
                                    <div class="col-4 profile-edit-column">
                                        <div class="form-group">
                                            <select data-width="100%" class="form-control custom-select"
                                                    name="{{$field->form_name}}"
                                                    id="{{'profileField'.$field->id}}">
                                                @foreach($countries as $country)
                                                    <option
                                                        {{$employee->citizenship == $country['name']['common']?"selected":""}} value="{{$country['name']['common']}}">{{$country['name']['common']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @break
                                    @case('nationality')
                                    <div class="col-4 profile-edit-column">
                                        <div class="form-group">
                                            <select data-width="100%" class="form-control custom-select"
                                                    name="{{$field->form_name}}"
                                                    id="{{'profileField'.$field->id}}">
                                                @foreach($countries as $country)
                                                    @continue(!$country['demonym'])
                                                    <option
                                                        {{$employee->nationality == $country['demonym']?"selected":""}} value="{{$country['demonym']}}">{{$country['demonym']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @break
                                    @case('sex')
                                    <div class="col-4 profile-edit-column">
                                        <div class="form-group">
                                            <select class="form-control" name="{{$field->form_name}}"
                                                    id="{{'profileField'.$field->id}}">
                                                @foreach($sexes as $key => $value)
                                                    <option
                                                        {{$employee->sex == $key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @break
                                    @case('status')
                                    <div class="col-4 profile-edit-column">
                                        <div class="form-group">
                                            <select class="form-control" name="{{$field->form_name}}"
                                                    id="{{'profileField'.$field->id}}">
                                                @foreach($statuses as $key => $value)
                                                    <option
                                                        {{$employee->status == $key?"selected":""}} value="{{$key}}">{{__($value)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @break
                                    @case('phone_number')
                                    <div class="col-4 profile-edit-column">
                                        <div class="form-group">
                                            <input class="form-control iti-input"
                                                   data-target="{{'profileField'.$field->id}}"
                                                   type="tel"
                                                   value="{{$employee->phone_number??""}}">
                                            <input type="hidden" id="{{'profileField'.$field->id}}"
                                                   name="{{$field->form_name}}"
                                                   value="{{$employee->phone_number??""}}">
                                        </div>
                                    </div>
                                    @break
                                    @case('birth_date')
                                    <div class="col-4 profile-edit-column">
                                        <div class="form-group">
                                            <input class="form-control"
                                                   id="{{'profileField'.$field->id}}"
                                                   name="{{$field->form_name}}" data-type="date" autocomplete="off"
                                                   placeholder="dd.mm.yyyy"
                                                   value="{{$employee->birth_date??""}}">
                                        </div>
                                    </div>
                                    @break
                                    @default
                                    <div class="col-4 profile-edit-column">
                                        @include('doc_fields.field',[
                                            'label' => $field->label,
                                            'formName' => $field->form_name,
                                            'fieldRequired' => $field->column=='avatar' && !empty($employee->avatar)? false : $field->required,
                                            'id' => 'profileField'.$field->id,
                                            'type' => $field->type->partial,
                                            'value' => $field->column
                                                        ? $employee->getAttribute($field->column)
                                                        : $employee->profileFormFields()->where('profile_form_field_id',$field->id)->first()->pivot->data,
                                            'noLabel' => true
                                        ])
                                    </div>
                                    @break
                                @endswitch
                            </div>
                        @endforeach
                    </form>
                </div>
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <button type="submit" form="employeeProfileForm"
                            class="btn btn-primary">{{__('Update Profile')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
