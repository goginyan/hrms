<fieldset class="border p-2 mb-2">
    <legend class="w-auto">DocType Parameters</legend>
    <div class="row">
        <div class="form-group col-6">
            <label for="display_name">Display name</label>
            <input value="{{$docType->display_name??""}}" type="text"
                   name="display_name" id="display_name"
                   class="form-control {{$errors->has('display_name')?"is-invalid":""}}">
            <div class="invalid-feedback">
                {{$errors->first('display_name')??""}}
            </div>
        </div>
        <div class="form-group col-6">
            <label for="name">Name</label>
            <input value="{{$docType->name??""}}" type="text"
                   name="name" id="name"
                   class="form-control {{$errors->has('display_name')?"is-invalid":""}}">
            <div class="invalid-feedback">
                {{$errors->first('display_name')??""}}
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="border p-2 mb-4">
    <legend class="w-auto">DocType Fields</legend>
    <ul class="list-group docTypes-list sortable">
        @if (!empty($docType))
            @foreach($docType->fields as $field)
                <li class="list-group-item mb-4 ui-state-default">
                    <div class="form-group m-0 form-inline d-flex justify-content-between align-items-center">
                        <select name="fields_types[]" class="form-control custom-select"
                                data-placeholder="Select field type">
                            @foreach($docFields as $f)
                                <option {{$f->id==$field->id?"selected":""}} value="{{$f->id}}">{{$f->name}}</option>
                            @endforeach
                        </select>
                        <div class="form-group mx-4 w-75">
                            <input placeholder="Label for field" value="{{$field->pivot->field_name??""}}" type="text"
                                   name="fields_names[]"
                                   class="form-control w-100 {{$errors->has('fields_names.'.$loop->index)?"is-invalid":""}}">
                            <div class="invalid-feedback">
                                {{$errors->first('fields_names.'.$loop->index)??""}}
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm btn-circle remove-field">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </li>
            @endforeach
        @endif
        <li class="list-group-item mb-4 ui-state-default d-none" id="initialForm">
            <div class="form-group form-inline d-flex m-0 justify-content-between align-items-center">
                <select class="form-control" data-placeholder="Select field type">
                    @foreach($docFields as $f)
                        <option value="{{$f->id}}">{{$f->name}}</option>
                    @endforeach
                </select>
                <div class="w-75 mx-4">
                    <input placeholder="Label for field" value="" type="text"
                           class="form-control w-100">
                </div>
                <button type="button" class="btn btn-danger btn-sm btn-circle remove-field">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </li>
    </ul>
    <div class="d-flex justify-content-center mt-2">
        <button id="addNewField" type="button" class="btn btn-primary">
            <i class="fa fa-plus-square mr-2"></i><span>Add Field</span>
        </button>
    </div>
</fieldset>
<fieldset class="border p-2 mb-4">
    <legend class="w-auto">DocType Approve Flow</legend>
    <div class="d-flex flex-wrap align-items-center steps-sequence">
        @if (!empty($docType))
            @foreach($docType->approveRoles as $role)
                <div class="form-group form-inline align-items-center mr-4 mb-3">
                    <select name="approveRoles[]" class="form-control">
                        @foreach($roles as $r)
                            @continue($r->id==1)
                            <option
                                {{$r->id == $role->id?"selected":""}} value="{{$r->id}}">{{$r->display_name}}</option>
                        @endforeach
                    </select>
                    @if($loop->index>0)
                        <button type="button" class="ml-2 btn btn-sm btn-circle btn-danger removeNewRole">
                            <i class="fa fa-minus-square"></i>
                        </button>
                    @endif
                    <input type="hidden" class="sequence" name="sequence[]" value="{{$role->pivot->sequence}}">
                </div>
            @endforeach
        @endif
    </div>
    <div class="d-flex justify-content-center mt-2">
        <button id="addNewRole" type="button" class="btn btn-primary mr-3">
            <i class="fa fa-plus-square mr-2"></i><span>Add Approve Step</span>
        </button>
    </div>
    <div id="initialStep" class="form-group form-inline align-items-center mr-4 mb-3 d-none">
        <select class="form-control">
            @foreach($roles as $r)
                @continue($r->id==1)
                <option value="{{$r->id}}">{{$r->display_name}}</option>
            @endforeach
        </select>
        <button type="button" class="ml-2 btn btn-sm btn-circle btn-danger removeNewRole">
            <i class="fa fa-minus-square"></i>
        </button>
        <input type="hidden" class="sequence" value="">
    </div>
</fieldset>
<fieldset class="border p-2 mb-4">
    <legend class="w-auto">DocType Creators</legend>
    <div class="form-group mb-3">
        <select multiple data-width="100%" name="createRoles[]" class="form-control custom-select"
                data-placeholder="Select creators roles">
            @foreach($roles as $r)
                @continue($r->id==1)
                <option
                    {{!empty($createRoles)&&in_array($r->id,$createRoles)?"selected":""}} value="{{$r->id}}">{{$r->display_name}}</option>
            @endforeach
        </select>
    </div>
</fieldset>