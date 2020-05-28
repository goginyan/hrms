<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Tag $Tag
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tag $blogTag)
    {
        $posts = !empty($blogTag->getAttributes()) ? $blogTag->posts : BlogPost::with('author')->get();

        return view('blog.index')->with([
            'posts'   => $posts,
            'recents' => BlogPost::latest()->with('author')->limit(7)->get(),
            'tags'    => Tag::with('posts')->get(),
            'title'   => !empty($blogTag->getAttributes()) ? "\"{$blogTag->title}\" " : "",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BlogPost $blogPost
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(BlogPost $blogPost)
    {
        return view('blog.show')->with([
            'post'    => $blogPost->loadMissing(['tags', 'author']),
            'recents' => BlogPost::latest()->with('author')->limit(7)->get(),
            'tags'    => Tag::with('posts')->get(),
        ]);
    }

    /**
     * Search the specified resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(BlogPost::class, 'title')
            ->search($request->search);

        return response()->json($searchResults->jsonSerialize());
    }
}
