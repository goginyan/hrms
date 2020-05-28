<div class="form-group">
    <label for="display_name">{{ __('Display Name') }}</label>
    <input value="{{$role->display_name??""}}" type="text" name="display_name" id="display_name"
           class="form-control {{$errors->has('display_name')?"is-invalid":""}}">
    <div class="invalid-feedback">
        {{$errors->first('display_name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" id="name" name="name" class="form-control {{$errors->has('name')?"is-invalid":""}}"
           value="{{$role->name??""}}">
    <div class="invalid-feedback">
        {{$errors->first('name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="parent">{{ __('Parent Role') }}</label>
    <select data-width="100%" name="parent" data-placeholder="{{__('Select Role')}}"
            id="parent" class="form-control custom-select">
        <option value="" selected>{{__("No parent")}}</option>
        @foreach($roles as $r)
            @continue($r->name==='root' || (isset($role) && $r->id==$role->id))
            <option value="{{$r->id}}" {{!empty($role->parent)&& $r->id==$role->parent->id?"selected":""}}>
                {{$r->display_name}}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('parent')?"d-block":""}}">
        {{$errors->first('parent')??""}}
    </div>
</div>
<div class="form-group">
    <label for="permissions">{{ __('Permissions') }}</label>
    <select data-width="100%" name="permissions[]" data-placeholder="{{__('Select Permissions')}}"
            id="permissions" multiple
            class="form-control custom-select">
        @foreach($permissions as $perm)
            <option value="{{$perm}}" {{isset($role)&&$role->hasPermissionTo($perm)?"selected":""}}>
                {{Str::title($perm)}}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('permissions.*')?"d-block":""}}">
        {{$errors->first('permissions.*')??""}}
    </div>
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" rows="5"
              class="form-control {{$errors->has('description')?"is-invalid":""}}">{{$role->description??""}}</textarea>
    <div class="invalid-feedback">
        {{$errors->first('description')??""}}
    </div>
</div>