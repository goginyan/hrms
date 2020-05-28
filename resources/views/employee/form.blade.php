<div class="form-group">
    <label for="name">{{ __('First Name') }}</label>
    <input value="{{$employee->first_name??""}}" type="text" id="name" name="first_name"
           class="form-control {{$errors->has('first_name')?"is-invalid":""}}">
    <div class="invalid-feedback">
        {{$errors->first('first_name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="last_name">{{ __('Last Name') }}</label>
    <input value="{{$employee->last_name??""}}" type="text" name="last_name" id="last_name"
           class="form-control {{$errors->has('last_name')?"is-invalid":""}}">
    <div class="invalid-feedback">
        {{$errors->first('last_name')??""}}
    </div>
</div>
<div class="form-group">
    <label for="email">{{ __('Email') }}</label>
    <input value="{{$employee->email??""}}" type="email" name="email" id="email"
           class="form-control {{$errors->has('email')?"is-invalid":""}}">
    <div class="invalid-feedback">
        {{$errors->first('email')??""}}
    </div>
</div>
<div class="form-group">
    <label for="password">{{ __('Password') }}</label>
    <input type="password" name="password" id="password"
           class="form-control {{$errors->has('password')?"is-invalid":""}}">
    <div class="invalid-feedback">
        {{$errors->first('password')??""}}
    </div>
</div>
<div class="form-group">
    <label for="confirm">{{ __('Confirm Password') }}</label>
    <input type="password" name="password_confirmation" id="confirm"
           class="form-control {{$errors->has('password_confirmation')?"is-invalid":""}}">
    <div class="invalid-feedback">
        {{$errors->first('password_confirmation')??""}}
    </div>
</div>
<div class="form-group">
    <label for="department">{{ __('Department') }}</label>
    <select name="department" data-placeholder="{{__('Select Department')}}"
            id="department" data-width="100%"
            class="form-control custom-select {{$errors->has('department')?"is-invalid":""}}">
        @foreach($departments as $department)
            <option
                {{isset($employee->department->id)&&$employee->department->id==$department->id?"selected":""}} value="{{$department->id}}">{{$department->name}}</option>
        @endforeach
    </select>
    <div class="invalid-feedback">
        {{$errors->first('department')??""}}
    </div>
</div>
<div class="form-group">
    <label for="manager">{{ __('Manager') }}</label>
    <select name="manager" data-placeholder="{{__('Select Manager')}}"
            id="manager" data-width="100%"
            class="form-control custom-select ">
        @foreach($managers as $manager)
            @continue(!$manager->user->role->children)
            <option
                {{isset($employee->manager->id)&&$employee->manager->id==$manager->id?"selected":""}} value="{{$manager->id}}">{{$manager->fullName}}
                - {{$manager->role}} ({{$manager->department->name}})
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('manager')?"d-block":""}}">
        {{$errors->first('manager')??""}}
    </div>
</div>
<div class="form-group">
    <label for="role">{{ __('Role') }}</label>
    <select name="role" data-width="100%" data-placeholder="{{__('Select Roles')}}"
            id="role" class="form-control custom-select {{$errors->has('role')?"is-invalid":""}}">
        @foreach($roles as $role)
            @continue($role->name == 'root')
            <option
                {{isset($employee)&&$employee->user->hasRole($role->name)?"selected":""}} value="{{$role->id}}">{{$role->display_name}}</option>
        @endforeach
    </select>
    <div class="invalid-feedback">
        {{$errors->first('role')??""}}
    </div>
</div>
<div class="form-group">
    <label for="status">{{ __('Employment Status') }}</label>
    <select name="status" data-width="100%" data-placeholder="{{__('Select Status')}}"
            id="status" class="form-control custom-select {{$errors->has('status')?"is-invalid":""}}">
        @foreach($statuses as $key=>$value)
            <option
                {{isset($employee)&&$employee->status==$value?"selected":""}} value="{{$key}}">{{__($value)}}</option>
        @endforeach
    </select>
    <div class="invalid-feedback">
        {{$errors->first('status')??""}}
    </div>
</div>
<div class="row">
    <div class="form-group col-6 d-flex flex-column">
        <label for="paid_time">{{__('Paid Time (days)')}}</label>
        <input value="{{$employee->paid_time??""}}" class="form-control" type="number" name="paid_time" id="paid_time">
        <div class="invalid-feedback">
            {{$errors->first('paid_time')??""}}
        </div>
    </div>
    <div class="form-group col-6 d-flex flex-column">
        <label for="unpaid_time">{{__('Unpaid Time (days)')}}</label>
        <input value="{{$employee->unpaid_time??""}}" class="form-control" type="number" name="unpaid_time"
               id="unpaid_time">
        <div class="invalid-feedback">
            {{$errors->first('unpaid_time')??""}}
        </div>
    </div>
</div>
