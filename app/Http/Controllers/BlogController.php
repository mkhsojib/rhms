<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->where('status', 'published')->latest()->paginate(10);
        return view('blog.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        if ($blog->status !== 'published') {
            abort(404);
        }
        $blog->load('category');
        return view('blog.show', compact('blog'));
    }
} 