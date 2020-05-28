@extends('layouts.dashboard')

@section('title','Blog Posts')

@section('content')
    <ul class="list-group list-group-flush">
        @foreach($posts as $post)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{route('blog-posts.show', $post)}}">
                    {{$post->title}}
                    <span title="{{__('Post author')}}"
                          class="badge badge-secondary badge-lg ml-2">by {{$post->author->fullName}}</span>
                </a>
                <form id="destroyPerm{{$post->id}}"
                      action="{{route('blog-posts.destroy', $post)}}"
                      method="post">
                    @csrf
                    @method('delete')
                </form>
                <button title="Remove" type="submit" form="destroyPerm{{$post->id}}"
                        class="btn btn-sm btn-circle btn-danger destroy-btn">
                    <i class="fa fa-times"></i>
                </button>
            </li>
        @endforeach
    </ul>
    @can('create posts')
        <div class="d-flex justify-content-end align-items-center mt-4">
            <a href="{{route('blog-posts.create')}}" class="btn btn-primary">{{__('Create Post')}}</a>
        </div>
    @endcan
@endsection
