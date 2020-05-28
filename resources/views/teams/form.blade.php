<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" id="name" name="name" class="form-control {{$errors->has('name')?"is-invalid":""}}"
           value="{{$team->name??""}}">
    <div class="invalid-feedback">
        {{$errors->first('name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="purpose">{{ __('Purpose') }}</label>
    <input type="text" name="purpose" id="purpose"
           class="form-control {{$errors->has('purpose')?"is-invalid":""}}"
           value="{{$team->purpose??""}}">
    <div class="invalid-feedback">
        {{$errors->first('purpose')??""}}
    </div>
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" cols="30" rows="10"
              class="form-control {{$errors->has('description')?"is-invalid":""}}">{{$team->description??""}}</textarea>
    <div class="invalid-feedback">
        {{$errors->first('description')??""}}
    </div>
</div>
<div class="form-group">
    <label for="members">{{ __('Members') }}</label>
    <select data-width="100%" name="members[]" data-placeholder="{{__('Select Members')}}"
            id="members" multiple class="form-control custom-select">
        @foreach($members as $m)
            @continue(Auth::user()->employee && $m->id==Auth::user()->employee->id)
            <option value="{{$m->id}}" {{isset($teamMembers)&&in_array($m->id,$teamMembers)?"selected":""}}>
                {{$m->fullName}}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('members')?"d-block":""}}">
        {{$errors->first('members')??""}}
    </div>
</div>
