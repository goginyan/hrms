<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostStoreRequest;
use App\Models\BlogPost;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\PostPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog_posts.index')->with([
            'posts' => BlogPost::with('author')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog_posts.add')->with([
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogPostStoreRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostStoreRequest $request)
    {
        $post  = Auth::user()->employee->posts()->create($request->all());
        $image = $request->file('image');
        if ($image) {
            $ext  = $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/posts/' . $post->id, "image.$ext");

            $newImage    = str_replace('public/', 'storage/', $path);
            $post->image = asset($newImage);
            $post->save();
        }
        foreach ($request->tags as $tag) {
            Tag::updateOrCreate(['title' => $tag]);
        }
        $post->tags()->sync($request->tags);
        \Notification::send(User::all(), new PostPublished($post));

        return redirect(route('blog-posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BlogPost $blogPost
     *
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $blogPost)
    {
        return view('blog_posts.show')->with([
            'post' => $blogPost->loadMissing(['tags', 'author'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\BlogPost $blogPost
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogPost)
    {
        return view('blog_posts.edit')->with([
            'post' => $blogPost->loadMissing('tags'),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogPostStoreRequest $request
     * @param \App\Models\BlogPost $blogPost
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostStoreRequest $request, BlogPost $blogPost)
    {
        $blogPost->update($request->all());
        $image = $request->file('image');
        if ($image) {
            $ext  = $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images/posts/' . $blogPost->id, "image.$ext");

            $newImage        = str_replace('public/', 'storage/', $path);
            $blogPost->image = asset($newImage);
            $blogPost->save();
        }
        foreach ($request->tags as $tag) {
            Tag::updateOrCreate(['title' => $tag]);
        }
        $blogPost->tags()->sync($request->tags);

        return redirect(route('blog-posts.show', $blogPost));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BlogPost $blogPost
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect(route('blog-posts.index'));
    }
}
