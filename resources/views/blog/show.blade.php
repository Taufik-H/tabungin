<x-app-layout>
    <article class="bg-white">
        <!-- Post Header -->
        <header class="bg-gradient-to-r from-violet-600 to-violet-800 text-white py-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-25">
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-primary-900 opacity-80"></div>
            </div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                @if($post->category)
                    <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" 
                       class="inline-block px-3 py-1 rounded-full text-xs font-medium mb-4"
                       style="background-color: {{ $post->category->color }}40; color: white;">
                        {{ $post->category->name }}
                    </a>
                @endif
                
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $post->title }}</h1>
                
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <img src="{{ $post->user->avatar ? Storage::url($post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                            alt="{{ $post->user->name }}" 
                            class="h-10 w-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">{{ $post->user->name }}</p>
                            <p class="text-sm text-primary-200">{{ $post->published_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <span class="text-primary-200">•</span>
                    
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $post->read_time }} min read</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Post Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if($post->excerpt)
                <div class="text-xl text-gray-600 mb-8 border-l-4 border-primary-500 pl-4 italic">
                    {{ $post->excerpt }}
                </div>
            @endif
            
            <div class="prose prose-lg max-w-none">
                {!! Str::of($post->content)->markdown() !!}
            </div>
            
            <!-- Post Tags -->
            <div class="flex flex-wrap items-center mt-12 pt-6 border-t border-gray-200">
                <span class="text-gray-700 mr-2">Share:</span>
                <div class="space-x-2">
                    <a href="#" class="inline-block text-gray-500 hover:text-primary-600 transition">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="inline-block text-gray-500 hover:text-primary-600 transition">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="inline-block text-gray-500 hover:text-primary-600 transition">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Author Info -->
            <div class="mt-12 bg-gray-50 rounded-lg p-6">
                <div class="flex items-center">
                    <img src="{{ $post->user->avatar ? Storage::url($post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                         alt="{{ $post->user->name }}" 
                         class="h-16 w-16 rounded-full mr-4">
                    <div>
                        <h3 class="text-lg font-bold">{{ $post->user->name }}</h3>
                        @if($post->user->bio)
                            <p class="text-gray-600">{{ $post->user->bio }}</p>
                        @else
                            <p class="text-gray-600">Author at {{ config('app.name') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Comments Section -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-8">Comments ({{ $post->comments->count() }})</h2>
                
                @auth
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                        <h3 class="text-lg font-medium mb-4">Leave a comment</h3>
                        
                        <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" 
                                          rows="4" 
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                                          placeholder="Your thoughts on this article..."
                                          required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-8 text-center">
                        <p class="text-gray-600 mb-4">Please sign in to leave a comment.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition">
                            Sign In
                        </a>
                    </div>
                @endauth
                
                <!-- Comments List -->
                <div class="space-y-6">
                    @forelse($post->comments()->whereNull('parent_id')->latest()->get() as $comment)
                        <div class="bg-white rounded-lg shadow-sm p-6" id="comment-{{ $comment->id }}">
                            <div class="flex items-start">
                                <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}" 
                                    alt="{{ $comment->user->name }}" 
                                    class="h-10 w-10 rounded-full mr-4">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        
                                        @auth
                                            @can('delete-comment', $comment)
                                                <div x-data="{ open: false }">
                                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="open" 
                                                        @click.away="open = false" 
                                                        x-cloak
                                                        class="absolute bg-white rounded-md shadow-lg py-1 mt-1 z-10 w-48">
                                                        <form action="#" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete Comment</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endcan
                                        @endauth
                                    </div>
                                    
                                    <div class="mt-2 text-gray-700">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    
                                    @auth
                                        <div class="mt-3 flex items-center space-x-4">
                                            <div x-data="{ showReplyForm: false }">
                                                <button @click="showReplyForm = !showReplyForm" class="text-sm text-primary-600 hover:text-primary-800 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Reply
                                                </button>
                                                
                                                <div x-show="showReplyForm" x-cloak class="mt-4">
                                                    <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <div class="mb-3">
                                                            <textarea name="content" 
                                                                    rows="3" 
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 text-sm"
                                                                    placeholder="Your reply..."
                                                                    required></textarea>
                                                        </div>
                                                        <div class="flex justify-end">
                                                            <button type="button" 
                                                                    @click="showReplyForm = false" 
                                                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-1 px-3 rounded-md text-sm mr-2">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" 
                                                                    class="bg-primary-600 hover:bg-primary-700 text-white py-1 px-3 rounded-md text-sm">
                                                                Post Reply
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                            
                            <!-- Replies -->
                            @if($comment->replies->count() > 0)
                                <div class="mt-4 pl-14 space-y-4">
                                    @foreach($comment->replies as $reply)
                                        <div class="bg-gray-50 rounded-lg p-4" id="comment-{{ $reply->id }}">
                                            <div class="flex items-start">
                                                <img src="{{ $reply->user->avatar ? Storage::url($reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}" 
                                                    alt="{{ $reply->user->name }}" 
                                                    class="h-8 w-8 rounded-full mr-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <h5 class="font-medium text-gray-900">{{ $reply->user->name }}</h5>
                                                            <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        
                                                        @auth
                                                            @can('delete-comment', $reply)
                                                                <div x-data="{ open: false }">
                                                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                        </svg>
                                                                    </button>
                                                                    <div x-show="open" 
                                                                        @click.away="open = false" 
                                                                        x-cloak
                                                                        class="absolute bg-white rounded-md shadow-lg py-1 mt-1 z-10 w-48">
                                                                        <form action="#" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete Reply</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endcan
                                                        @endauth
                                                    </div>
                                                    
                                                    <div class="mt-1 text-gray-700 text-sm">
                                                        <p>{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                            <p class="text-gray-600">No comments yet. Be the first to share your thoughts!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </article>
    
    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-8">Related Articles</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition">
                            <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                @if($relatedPost->featured_image)
                                    <img src="{{ Storage::url($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="p-5">
                                <div class="mb-2">
                                    @if($relatedPost->category)
                                        <a href="{{ route('blog.index', ['category' => $relatedPost->category->slug]) }}" 
                                           class="inline-block px-3 py-1 rounded-full text-xs font-medium"
                                           style="background-color: {{ $relatedPost->category->color }}20; color: {{ $relatedPost->category->color }};">
                                            {{ $relatedPost->category->name }}
                                        </a>
                                    @endif
                                </div>
                                
                                <h3 class="text-lg font-bold mb-2">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-gray-900 hover:text-primary-600 transition">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ $relatedPost->excerpt ?? Str::limit(strip_tags($relatedPost->content), 80) }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $relatedPost->user->avatar ? Storage::url($relatedPost->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($relatedPost->user->name) }}" 
                                            alt="{{ $relatedPost->user->name }}" 
                                            class="h-6 w-6 rounded-full mr-2">
                                        <span class="text-xs text-gray-600">{{ $relatedPost->user->name }}</span>
                                    </div>
                                    
                                    <span class="text-xs text-gray-500">{{ $relatedPost->published_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-app-layout>