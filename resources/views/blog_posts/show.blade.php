@extends('layouts.dashboard')

@section('title','Blog Post Details')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card blog-post">
                <img src="{{$post->image??asset('images/blog/no_image.png')}}" class="card-img-top"
                     alt="Featured Image">
                <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p class="card-text blog-post-body">{{$post->text}}</p>
                    <p class="card-text d-flex justify-content-between mt-4 align-items-center">
                        <small class="text-muted">{{$post->created_at->diffForHumans()}}</small>
                        <small class="text-muted">by {{$post->author->fullName}}</small>
                    </p>
                    <p class="card-text d-flex justify-content-end align-items-center">
                        @foreach($post->tags as $tag)
                            <small class="text-muted blog-post-tag">{{$tag->title}}</small>
                        @endforeach
                    </p>
                </div>
            </div>
            @can('manage blog')
                <form id="destroyPerm{{$post->id}}"
                      action="{{route('blog-posts.destroy', $post)}}"
                      method="post">
                    @csrf
                    @method('delete')
                </form>
            @endcan
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{route('blog-posts.index')}}" class="btn btn-outline-primary">{{__('Back To List')}}</a>
                @can('manage blog')
                    <button title="Remove" type="submit" form="destroy{{$post->id}}"
                            class="btn btn-danger destroy-btn">{{__('Delete Post')}}
                    </button>
                    <a href="{{route('blog-posts.edit',$post)}}" class="btn btn-primary">{{__('Edit Post')}}</a>
                @endcan
            </div>
        </div>
    </div>
@endsection