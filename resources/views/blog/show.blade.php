@extends('layouts.public')

@section('title', $post->title)

@section('content')
    <section class=" iq-breadcrumb3 text-left main-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="mb-0">
                        <h1 class="text-white">{{$post->title}}</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <nav aria-label="breadcrumb" class="text-right">
                        <ol class="breadcrumb main-bg">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">
                                    <i class="fas fa-home"></i> {{__('Home')}}</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('blog.index')}}">{{__('Blog')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
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
                    <h3 class="mt-4 mb-3">{{$post->title}}</h3>
                    <div class="card blog-post mb-4">
                        <img src="{{$post->image??asset('images/blog/no_image.png')}}" class="card-img-top"
                             alt="Featured Image">
                        <div class="card-body">
                            <p class="card-text blog-post-body">{{$post->text}}</p>
                            <p class="card-text d-flex justify-content-between mt-4 align-items-center">
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
                    </div>
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