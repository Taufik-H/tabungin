<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
                    ->published()
                    ->latest('published_at');
        
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        
        $posts = $query->paginate(9);
        $categories = Category::withCount('posts')->get();
        
        return view('blog.index', compact('posts', 'categories'));
    }
    
    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'comments.user', 'comments.replies.user'])
                    ->where('slug', $slug)
                    ->published()
                    ->firstOrFail();
        
        $relatedPosts = Post::with(['user', 'category'])
                            ->where('id', '!=', $post->id)
                            ->where(function ($query) use ($post) {
                                if ($post->category_id) {
                                    $query->where('category_id', $post->category_id);
                                }
                            })
                            ->published()
                            ->latest('published_at')
                            ->take(3)
                            ->get();
        
        return view('blog.show', compact('post', 'relatedPosts'));
    }
    
    public function comment(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required|min:3',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $post = Post::where('slug', $slug)->firstOrFail();
        
        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);
        
        return back()->with('success', 'Comment added successfully!');
    }
}