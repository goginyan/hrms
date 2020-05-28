<div class="form-group">
    <label for="title">{{__('Title')}}</label>
    <input required type="text" value="{{$redeemable->title??''}}" class="form-control" id="title" name="title">
    <div class="invalid-feedback">
        {{$errors->first('title')??""}}
    </div>
</div>
<div class="form-group">
    <label for="description">{{__('Description')}}</label>
    <textarea type="text" class="form-control" id="description"
              name="description">{{$redeemable->description??''}}</textarea>
    <div class="invalid-feedback">
        {{$errors->first('description')??""}}
    </div>
</div>
<div class="form-group">
    <label for="price">{{__('Price')}}</label>
    <input required type="number" value="{{$redeemable->price??''}}" min="5" step="5" class="form-control" id="price"
           name="price">
    <div class="invalid-feedback">
        {{$errors->first('price')??""}}
    </div>
</div>
<div class="form-group">
    <label for="image">{{__('Image')}}</label>
    <div class="custom-file">
        <input type="file" required
               class="custom-file-input {{$errors->has('image')?"is-invalid":""}}"
               id="image"
               name="image">
        <div class="invalid-feedback">
            {{$errors->first('image')??""}}
        </div>
        <label class="custom-file-label" for="image">{{$redeemable->image??__('Choose File')}}</label>
    </div>
</div>