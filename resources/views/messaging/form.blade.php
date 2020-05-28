<div class="form-group">
    <label for="display_name">{{ __('Display Name') }}</label>
    <input type="text" name="display_name" id="display_name"
           class="form-control {{$errors->has('display_name')?"is-invalid":""}}"
           value="{{$permission->display_name??""}}">
    <div class="invalid-feedback">
        {{$errors->first('display_name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" id="name" name="name" class="form-control {{$errors->has('name')?"is-invalid":""}}"
           value="{{$permission->name??""}}">
    <div class="invalid-feedback">
        {{$errors->first('name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" cols="30" rows="10"
              class="form-control">{{$permission->description??""}}</textarea>
</div>
