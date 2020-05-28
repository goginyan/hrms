<div class="form-group">
    <label for="type">{{__('Type')}} *</label>
    <select name="type" id="type" class="form-control" required>
        @foreach ($types as $key=>$type)
            <option value="{{$key}}">{{__($type)}}</option>
        @endforeach
    </select>
</div>
<div class="form-group d-flex flex-wrap">
    <div class="custom-control custom-radio custom-control-inline mr-4">
        <input type="radio" {{Auth::user()->employee->paid_time>0?'checked':'disabled'}} class="custom-control-input"
               id="customRadio" name="paid" value="1">
        <label class="custom-control-label" for="customRadio">{{__('Paid')}}</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" {{Auth::user()->employee->paid_time<=0?'checked':''}} class="custom-control-input"
               id="customRadio2" name="paid" value="0">
        <label class="custom-control-label" for="customRadio2">{{__('Unpaid')}}</label>
    </div>
</div>
<div class="form-group date-input vacation d-none">
    <label for="vacation">{{__('Select period')}} *</label>
    <input data-type="daterange" data-min-date="today" autocomplete="off" placeholder="dd.mm.yyyy to dd.mm.yyyy"
           id="vacation" class="form-control">
</div>
<div class="form-group date-input day-off">
    <label for="day_off">{{__('Select date')}} *</label>
    <input data-type="date" required data-min-date="today" data-weekend="false" autocomplete="off"
           placeholder="dd.mm.yyyy"
           id="day_off" class="form-control">
</div>
<div class="form-group date-input d-none other-types">
    <label for="started_at">{{__('Start Datetime')}} *</label>
    <input data-type="datetime" data-min-date="today" data-weekend="false" autocomplete="off"
           placeholder="hh:mm dd.mm.yyyy"
           name="started_at" id="started_at" class="form-control">
</div>
<div class="form-group date-input d-none other-types">
    <label for="finished_at">{{__('End Datetime')}} *</label>
    <input data-type="datetime" data-weekend="false" autocomplete="off" placeholder="hh:mm dd.mm.yyyy"
           name="finished_at" id="finished_at" class="form-control">
</div>
<div class="form-group">
    <label for="reason">{{ __('Reason') }}</label>
    <textarea class="form-control" name="reason" rows="5" id="reason"></textarea>
</div>