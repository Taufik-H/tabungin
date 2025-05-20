<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ForumController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Discussion::with(['user', 'category'])
                        ->withCount(['comments', 'likes']);
                        
        // Apply filters
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Apply sorting
        $sort = $request->sort ?? 'latest';
        
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('view_count');
                break;
            case 'most_comments':
                $query->orderByDesc('comments_count');
                break;
            case 'most_likes':
                $query->orderByDesc('likes_count');
                break;
            default:
                $query->latest();
        }
        
        // Pin discussions at the top
        $query->orderByDesc('is_pinned');
        
        $discussions = $query->paginate(10);
        $categories = Category::withCount('discussions')->get();
        
        return view('forum.index', compact('discussions', 'categories', 'sort'));
    }
    
    public function show($slug)
    {
        $discussion = Discussion::with(['user', 'category', 'comments.user', 'comments.replies.user', 'comments.likes', 'likes'])
                            ->where('slug', $slug)
                            ->firstOrFail();
        
        // Increment view count
        $discussion->incrementViewCount();
        $comments = $discussion->comments()->whereNull('parent_id')->latest()->paginate(6);

        $relatedDiscussions = Discussion::with(['user', 'category'])
                                    ->withCount(['comments', 'likes'])
                                    ->where('id', '!=', $discussion->id)
                                    ->where(function ($query) use ($discussion) {
                                        if ($discussion->category_id) {
                                            $query->where('category_id', $discussion->category_id);
                                        }
                                    })
                                    ->orderByDesc('created_at')
                                    ->take(5)
                                    ->get();
        
        return view('forum.show', compact('discussion', 'relatedDiscussions','comments'));
    }
    
    public function create()
    {
        $this->authorize('create', Discussion::class);
        
        $categories = Category::all();
        
        return view('forum.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', Discussion::class);
        
        $request->validate([
            'title' => 'required|min:5|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|min:10',
        ]);
        
        $discussion = new Discussion();
        $discussion->user_id = auth()->id();
        $discussion->category_id = $request->category_id;
        $discussion->title = $request->title;
        $discussion->slug = Str::slug($request->title) . '-' . Str::random(5);
        $discussion->content = $request->content;
        $discussion->save();
        
        return redirect()->route('forum.show', $discussion->slug)
                        ->with('success', 'Discussion created successfully!');
    }
    
    public function comment(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required|min:3',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $discussion = Discussion::where('slug', $slug)->firstOrFail();
        
        if ($discussion->is_locked) {
            return back()->with('error', 'This discussion is locked and cannot receive new comments.');
        }
        
        $discussion->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);
        
        return back()->with('success', 'Comment added successfully!');
    }
    
    public function like(Request $request, $id)
    {
        $discussion = Discussion::findOrFail($id);
        
        $existing = Like::where('user_id', auth()->id())
                    ->where('likeable_id', $discussion->id)
                    ->where('likeable_type', get_class($discussion))
                    ->first();
        
        if ($existing) {
            $existing->delete();
            $message = 'Like removed successfully.';
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'likeable_id' => $discussion->id,
                'likeable_type' => get_class($discussion)
            ]);
            $message = 'Discussion liked successfully.';
        }
        
        if ($request->ajax()) {
            return response()->json(['message' => $message, 'count' => $discussion->likes()->count()]);
        }
        
        return back()->with('success', $message);
    }
    
    public function likeComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        
        $existing = Like::where('user_id', auth()->id())
                    ->where('likeable_id', $comment->id)
                    ->where('likeable_type', get_class($comment))
                    ->first();
        
        if ($existing) {
            $existing->delete();
            $message = 'Like removed successfully.';
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'likeable_id' => $comment->id,
                'likeable_type' => get_class($comment)
            ]);
            $message = 'Comment liked successfully.';
        }
        
        if ($request->ajax()) {
            return response()->json(['message' => $message, 'count' => $comment->likes()->count()]);
        }
        
        return back()->with('success', $message);
    }
    public function deleteComment($id)
{
    $comment = Comment::findOrFail($id);

    // Authorization
    $this->authorize('delete-comment', $comment);

    $comment->delete();

    return back()->with('success', 'Comment deleted successfully.');
}
public function destroy($id)
{
    $discussion = DiscussionTopic::findOrFail($id);
    
    // Logika untuk menghapus diskusi
    $discussion->delete();
    
    return redirect()->route('forum.index')->with('success', 'Diskusi berhasil dihapus');
}

}