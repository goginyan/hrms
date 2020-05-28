@extends('layouts.dashboard')

@section('title','Create Blog Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create posts')
                        <form enctype="multipart/form-data" action="{{route('blog-posts.store')}}" method="post">
                            @csrf
                            @include('blog_posts.form')
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('blog-posts.index')}}"
                                   class="btn btn-outline-primary">{{__('Back To List')}}</a>
                                <button class="btn btn-primary">{{ __('Create') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
