<div class="form-group">
    <label for="title">{{ __('Title') }}</label>
    <input type="text" required id="title" name="title" class="form-control {{$errors->has('title')?"is-invalid":""}}"
           value="{{$post->title??""}}">
    <div class="invalid-feedback">
        {{$errors->first('title')??""}}
    </div>
</div>
<div class="form-group">
    <label for="image">{{ __('Featured Image') }}</label>
    <div class="custom-file">
        <input name="image" type="file" class="custom-file-input {{$errors->has('image')?"is-invalid":""}}" id="image">
        <label class="custom-file-label" for="image">{{$post->image??__('Select Image')}}</label>
    </div>
    <div class="invalid-feedback">
        {{$errors->first('image')??""}}
    </div>
</div>
<div class="form-group">
    <label for="text">{{ __('Text') }}</label>
    <textarea required name="text" id="text" cols="30" rows="15"
              class="form-control {{$errors->has('text')?"is-invalid":""}}">{{$post->text??""}}</textarea>
    <div class="invalid-feedback">
        {{$errors->first('text')??""}}
    </div>
</div>
<div class="form-group">
    <label for="tags">{{ __('Tags') }}</label>
    <select name="tags[]" data-placeholder="{{__('Select Tags')}}"
            id="tags" multiple class="form-control tags-select">
        @foreach($tags as $t)
            <option value="{{$t->title}}" {{isset($post)&&$post->tags->contains($t)?"selected":""}}>
                {{$t->title}}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback {{$errors->has('tags')?"d-block":""}}">
        {{$errors->first('tags')??""}}
    </div>
</div>
