@extends('layouts.dashboard')

@section('title','Profile Form Fields')

@section('content')
    <div class="row">
        <div class="col-12">
            @can('manage profile-form')
                <div class="row bg-primary text-light mb-3 border-bottom">
                    <div class="col-10 row">
                        <span class="col-4">{{__('Field Label')}}</span>
                        <span class="col-2">{{__('Active')}}</span>
                        <span class="col-2">{{__('Required')}}</span>
                        <span class="col-4">{{__('Field Type')}}</span>
                    </div>
                    <span class="col-2">{{__('Delete')}}</span>
                </div>
                @foreach($fields as $field)
                    <div class="row py-2 border-bottom bg-light">
                        <form id="updateForm{{$field->id}}" method="post"
                              class="col-10 row"
                              action="{{route('profile.form.update',$field)}}">
                            @csrf
                            @method('put')
                            @empty($field->column)
                                <div class="col-4 form-group d-flex align-items-center m-0">
                                    <input name="label" type="text" value="{{$field->label??""}}"
                                           class="form-control profile-field-update">
                                </div>
                            @else
                                <span class="col-4 d-flex align-items-center">{{$field->label}}</span>
                            @endempty
                            <div class="custom-control custom-checkbox d-flex align-items-center col-2">
                                <input name="active"
                                       {{$field->is_protected?"disabled":""}} type="checkbox"
                                       {{$field->active?"checked":""}} value="true"
                                       class="custom-control-input profile-field-update" id="active{{$field->id}}">
                                <label class="custom-control-label" for="active{{$field->id}}">{{__('Active')}}</label>
                            </div>
                            <div class="custom-control custom-checkbox d-flex align-items-center col-2">
                                <input name="required"
                                       {{$field->is_protected?"disabled":""}} type="checkbox"
                                       {{$field->required?"checked":""}} value="true"
                                       class="custom-control-input profile-field-update"
                                       id="required{{$field->id}}">
                                <label class="custom-control-label"
                                       for="required{{$field->id}}">{{__('Required')}}</label>
                            </div>
                            <div class="form-group d-flex align-items-center m-0 col-4">
                                <select {{$field->column?"disabled":""}} name="type_id" title="{{__('Field type')}}"
                                        class="form-control profile-field-update">
                                    @foreach ($types as $type)
                                        <option
                                            {{$field->type->id==$type->id?"selected":""}} value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <span class="d-flex justify-content-center align-items-center col-2">
                            @empty($field->column)
                                <form id="destroyField{{$field->id}}"
                                      action="{{route('profile.form.destroy', $field)}}"
                                      method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button title="Remove" type="submit" form="destroyField{{$field->id}}"
                                        class="btn btn-sm btn-circle btn-danger destroy-btn ml-3">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endempty
                        </span>
                    </div>
                @endforeach
            @endcan
        </div>
    </div>
    <div class="d-flex justify-content-end align-items-center mt-4">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createNewField">
            {{__('Create Field')}}
        </button>
    </div>
    <div class="modal fade" id="createNewField" role="dialog" aria-labelledby="createNewFieldTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNewFieldLongTitle">{{__('Create New Field')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="modal-body" action="{{route('profile.form.store')}}" method="post" id="newField">
                    @csrf
                    <div class="form-group">
                        <label for="fieldLabel">{{__('Label of the field')}}</label>
                        <input type="text" name="label" id="fieldLabel" class="form-control">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" form="newField" class="btn btn-primary">{{__('Create')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
