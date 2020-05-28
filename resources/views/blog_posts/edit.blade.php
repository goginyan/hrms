@extends('layouts.dashboard')

@section('title','Edit Blog Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('manage blog')
                        <form enctype="multipart/form-data" action="{{route('blog-posts.update',$post)}}" method="post">
                            @csrf
                            @method('put')
                            @include('blog_posts.form')
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('blog-posts.show',$post)}}"
                                   class="btn btn-outline-primary">{{__('Back')}}</a>
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
