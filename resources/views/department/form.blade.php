<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" id="name" name="name" class="form-control {{$errors->has('name')?"is-invalid":""}}"
           value="{{$department->name??""}}">
    <div class="invalid-feedback">
        {{$errors->first('name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="parent">{{ __('Parent') }}</label>
    <select data-width="100%" name="parent_id" id="parent"
            class="form-control custom-select {{$errors->has('parent')?"is-invalid":""}}"
            data-placeholder="Select Parent Department">
        <option value="">{{__('Select Parent Department')}}</option>
        @foreach($departments as $dep)
            <option
                {{isset($department->parent) && $department->parent->id==$dep->id ? "selected" : ""}} value="{{$dep->id}}">{{$dep->name}}</option>
        @endforeach
    </select>
    <div class="invalid-feedback">
        {{$errors->first('parent_id')??""}}
    </div>
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" cols="30" rows="10"
              class="form-control">{{$department->description??""}}</textarea>
</div>
