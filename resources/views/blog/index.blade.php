@extends('layouts.public')

@section('title', __('Blog'))

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{__('Blog')}}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i
                                        class="fas fa-home"></i> {{__('Home')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Blog')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <img class="img-fluid iq-breadcrumb3-after" src="{{asset('images/theme/about/about-shap.png')}}" alt="image">
    </section>
    <div class="main-content my-4">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-12 col-md-9">
                    <h3 class="mt-4 mb-3">{{$title . __('Posts Feed')}}</h3>
                    @foreach($posts as $post)
                        <div class="card mb-4 blog-post">
                            <div class="row no-gutters align-items-stretch">
                                <div class="col-md-4">
                                    <img src="{{$post->image??asset('images/blog/no_image.png')}}" class="card-img"
                                         alt="Featured Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title m-0">{{$post->title}}</h5>
                                        <p class="card-text blog-post-preview m-0">{{$post->preview}}</p>
                                        <p class="card-text d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">{{$post->created_at->diffForHumans()}}</small>
                                            <small class="text-muted">by {{$post->author->fullName}}</small>
                                        </p>
                                        <p class="card-text d-flex justify-content-end align-items-center">
                                            @foreach($post->tags as $tag)
                                                <a href="{{route('blog.index',$tag)}}"
                                                   class="small blog-post-tag">{{$tag->title}}</a>
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end">
                                        <a class="btn btn-primary"
                                           href="{{route('blog.show', $post)}}">{{__('Read more')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-none d-md-flex flex-column col-md-3">
                    <h3 class="mt-4 mb-3"><label class="m-0" for="search">{{__('Search')}}</label></h3>
                    <div class="form-group">
                        <input data-url="{{route('blog.search')}}" autocomplete="off" type="text" name="search"
                               id="search" class="form-control email-bg">
                    </div>
                    <h3 data-search="{{__('Search Results')}}"
                        class="mt-4 mb-3 results-heading">{{__('Recent Posts')}}</h3>
                    <ul class="list-group list-group-flush mb-5 results-list">
                        @foreach($recents as $post)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{route('blog.show', $post)}}">{{$post->title}}</a>
                                <span class="badge badge-primary badge-lg ml-2">by {{$post->author->fullName}}</span>
                            </li>
                        @endforeach
                    </ul>
                    <h3 class="mt-4 mb-3">{{__('Tags')}}</h3>
                    <ul class="list-group list-group-flush">
                        @foreach($tags as $tag)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{route('blog.index', $tag)}}">{{$tag->title}}</a>
                                <span title="{{__('Posts')}}"
                                      class="badge badge-primary badge-lg ml-2">{{$tag->posts->count()??0}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection