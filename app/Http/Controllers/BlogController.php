<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $blogs = Blog::query()
            ->orderBy('created_at', 'DESC')
            ->filter($request->only('filter'))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Blog/Index', [
            'blogs' => $blogs,
            'filters' => $request->all('filter'),
            'message' => session('message'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Blog/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'slug' => 'required|unique:blogs|string|max:255'
        ]);
        Blog::create([
            'heading' => $request->heading,
            'slug' => Str::slug($request->slug),
            'description' => $request->description
        ]);

        return redirect()->route('blogs.index')->with('message', 'Blog Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return Inertia::render(
            'Blog/View',
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return Inertia::render(
            'Blog/Edit',
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'slug' => 'required||unique:blogs,slug,'.$blog->id.',id|string|max:255'
        ]);
        $blog->update([
            'heading' => $request->heading,
            'slug' => Str::slug($request->slug),
            'description' => $request->description
        ]);

        return redirect()->route('blogs.index')->with('message', 'Blog Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('message', 'Blog Post Deleted Successfully');
    }
}
