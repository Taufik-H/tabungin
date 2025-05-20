<x-app-layout>
<style>
    [x-cloak] { display: none !important; }
</style>
  
<div x-data="discussion()">
        <!-- Discussion Header -->
        <section class="bg-[#b4adff] text-white rounded-b-[50px] py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto" 
                x-data="{
    isLiked: {{ json_encode($discussion->likes->contains('user_id', auth()->id())) }},
    likeCount: {{ $discussion->likes->count() }},
    isAnimating: false,
    toggleLike() {
        this.isLiked = !this.isLiked;
        this.likeCount += this.isLiked ? 1 : -1;
        
        // Mulai animasi
        this.isAnimating = true;
        setTimeout(() => this.isAnimating = false, 300); // animasi 300ms
        
        // Submit form
        this.$refs.likeForm.submit();
    }
}"

                >
                    <div class="flex items-center space-x-2 text-sm mb-4">
                        <a href="{{ route('forum.index') }}" class="text-violet-100 hover:text-white transition">Forum</a>
                        <span>•</span>
                        @if($discussion->category)
                            <a href="{{ route('forum.index', ['category' => $discussion->category->slug]) }}" class="text-violet-100 hover:text-white transition">{{ $discussion->category->name }}</a>
                        @else
                            <span class="text-violet-100">General</span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold mb-6">{{ $discussion->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center">
                            <img src="{{ $discussion->user->avatar ? Storage::url($discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}" 
                                alt="{{ $discussion->user->name }}" 
                                class="h-10 w-10 rounded-full mr-3">
                            <div>
                                <p class="font-medium">{{ $discussion->user->name }}</p>
                                <p class="text-sm text-violet-200">{{ $discussion->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-6 text-sm">
                            <div class="flex items-center" title="Views">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $discussion->view_count + 1 }}</span>
                            </div>
                            
                            <div class="flex items-center" title="Comments">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $discussion->comments->count() }}</span>
                            </div>

                            <div class="flex items-center" title="Likes">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                </svg>
                                <span x-text="likeCount">{{ $discussion->likes->count() }}</span>
                            </div>
                        </div>
                        
                        <div class="flex ml-auto">
                            @auth
                                <form x-ref="likeForm" action="{{ route('forum.like', $discussion->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button"
    x-cloak
    @click="toggleLike"
    :class="[
        'flex items-center px-3 py-1 rounded-md transition-all duration-300 ease-in-out focus:outline-none',
        isLiked ? 'bg-white text-violet-700' : 'bg-violet-800 text-white hover:bg-violet-700',
        isAnimating ? 'scale-110' : 'scale-100'
    ]">
    <svg xmlns="http://www.w3.org/2000/svg" 
        class="h-5 w-5 mr-1 transition-transform duration-300"
        :class="isAnimating ? 'rotate-12' : ''"
        viewBox="0 0 20 20" fill="currentColor">
        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
    </svg>
    <span x-text="isLiked ? 'Liked' : 'Like'"></span>
</button>


                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Discussion Content -->
        <div class="bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="max-w-4xl mx-auto">
                    <div class="prose prose-lg max-w-none">
                        {!! Str::of($discussion->content)->markdown() !!}
                    </div>
                    
                    <!-- Tags & Share -->
                    <div class="flex flex-wrap items-center mt-12 pt-6 border-t border-gray-200">
                        @if($discussion->category)
                            <a href="{{ route('forum.index', ['category' => $discussion->category->slug]) }}" 
                              class="inline-block px-3 py-1 rounded-full text-xs font-medium mr-2 mb-2"
                              style="background-color: {{ $discussion->category->color }}20; color: {{ $discussion->category->color }};">
                                {{ $discussion->category->name }}
                            </a>
                        @endif
                        
                        <div class="ml-auto">
                            <span class="text-gray-700 mr-2">Share:</span>
                            <div class="inline-flex space-x-2">
                                <a href="#" class="text-gray-500 hover:text-violet-600 transition">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-violet-600 transition">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-500 hover:text-violet-600 transition">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
     <!-- Comments Section -->
<section class="bg-gray-50 py-10 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                    Comments <span class="text-violet-600">({{ $discussion->comments->count() }})</span>
                </h2>
                
                @if($discussion->comments->count() > 0)
                    <div class="hidden sm:block">
                        <a href="#comment-form" class="inline-flex items-center text-violet-600 hover:text-violet-700 font-medium text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                            </svg>
                            Add your comment
                        </a>
                    </div>
                @endif
            </div>
            
            @auth
                @if(!$discussion->is_locked)
                    <div id="comment-form" class="bg-white rounded-lg shadow-sm p-5 md:p-6 mb-8">
                        <div class="flex items-start mb-4">
                            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                alt="{{ auth()->user()->name }}" 
                                class="h-10 w-10 rounded-full mr-3 object-cover border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Add your comment</h3>
                        </div>
                        
                        <form action="{{ route('forum.comment', $discussion->slug) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" 
                                        rows="4" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50"
                                        placeholder="Share your thoughts..."
                                        required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded-md transition shadow-sm font-medium">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-100 rounded-lg p-5 md:p-6 mb-8 flex items-center justify-center">
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <span>This discussion is locked. No new comments can be added.</span>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-white rounded-lg shadow-sm p-5 md:p-6 mb-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="text-gray-600 mb-4">Please sign in to leave a comment.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded-md transition shadow-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd" />
                        </svg>
                        Sign In
                    </a>
                </div>
            @endauth
            
            <!-- Comments List -->
            <div class="space-y-6">
                @forelse($comments as $comment)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden" id="comment-{{ $comment->id }}">
                        <div class="p-5 md:p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-4">
                                    <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}" 
                                        alt="{{ $comment->user->name }}" 
                                        class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        
                                        @auth
                                            <div class="flex items-center space-x-3">
                                                <form x-data="{ liked: {{ $comment->likes->where('user_id', auth()->id())->count() > 0 ? 'true' : 'false' }}, likeCount: {{ $comment->likes->count() }} }" 
                                                      action="{{ route('comment.like', $comment->id) }}" 
                                                      method="POST"
                                                      class="inline">
                                                    @csrf
                                                    <button type="button"
                                                            @click="
                                                                fetch('{{ route('comment.like', $comment->id) }}', {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        'Content-Type': 'application/json',
                                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                    },
                                                                    credentials: 'same-origin'
                                                                })
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    liked = !liked;
                                                                    likeCount = data.count;
                                                                    $el.classList.add('animate-like');
                                                                    setTimeout(() => $el.classList.remove('animate-like'), 500);
                                                                });
                                                            "
                                                            class="flex items-center text-gray-500 hover:text-violet-600 transition"
                                                            :class="liked ? 'text-violet-600 fill-violet-600 font-semibold' : ''"
                                                        >

                                                </form>
                                                
                                                @can('delete-comment', $comment)
                                                    <div x-data="{ open: false }" class="relative">
                                                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            </svg>
                                                        </button>
                                                        <div x-show="open" 
                                                            @click.away="open = false" 
                                                            x-cloak
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="transform opacity-0 scale-95"
                                                            x-transition:enter-end="transform opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-75"
                                                            x-transition:leave-start="transform opacity-100 scale-100"
                                                            x-transition:leave-end="transform opacity-0 scale-95"
                                                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                                                            <form action="#" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition">
                                                                    <div class="flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        Delete Comment
                                                                    </div>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endcan
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2a1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                </svg>
                                                <span class="text-gray-500">{{ $comment->likes->count() }}</span>
                                            </div>
                                        @endauth
                                    </div>
                                    
                                    <div class="mt-3 text-gray-700 prose prose-sm max-w-none">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    
                                    @auth
                                        @if(!$discussion->is_locked)
                                            <div class="mt-4 flex items-center space-x-4">
                                                <div x-data="{ showReplyForm: false }">
                                                    <button @click="showReplyForm = !showReplyForm" class="text-sm text-violet-600 hover:text-violet-800 flex items-center font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Reply
                                                    </button>
                                                    
                                                    <div x-show="showReplyForm" 
                                                         x-cloak 
                                                         x-transition:enter="transition ease-out duration-200"
                                                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                                         x-transition:leave="transition ease-in duration-150"
                                                         x-transition:leave-start="opacity-100 transform translate-y-0"
                                                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                                                         class="mt-4 bg-gray-50 p-4 rounded-md border border-gray-200">
                                                        <form action="{{ route('forum.comment', $discussion->slug) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                            <div class="mb-3">
                                                                <textarea name="content" 
                                                                        rows="3" 
                                                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50 text-sm"
                                                                        placeholder="Your reply..."
                                                                        required></textarea>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <button type="button" 
                                                                        @click="showReplyForm = false" 
                                                                        class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-1.5 px-3 rounded-md text-sm mr-2 font-medium">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" 
                                                                        class="bg-violet-600 hover:bg-violet-700 text-white py-1.5 px-3 rounded-md text-sm font-medium shadow-sm">
                                                                    Post Reply
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                        
                        <!-- Replies -->
                        @if($comment->replies->count() > 0)
                            <div class="border-t border-gray-100">
                                <div class="pl-6 md:pl-10 pr-5 md:pr-6 py-4 bg-gray-50">
                                    <div class="space-y-4">
                                        @foreach($comment->replies as $reply)
                                            <div class="flex items-start" id="comment-{{ $reply->id }}">
                                                <div class="flex-shrink-0 mr-3">
                                                    <img src="{{ $reply->user->avatar ? Storage::url($reply->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}" 
                                                        alt="{{ $reply->user->name }}" 
                                                        class="h-8 w-8 rounded-full object-cover border border-gray-200">
                                                </div>
                                                <div class="flex-1 min-w-0 bg-white rounded-md p-3 shadow-sm">
                                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                                        <div>
                                                            <h5 class="font-medium text-gray-900 text-sm">{{ $reply->user->name }}</h5>
                                                            <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                                        </div>
                                                        
                                                        @auth
                                                            <div class="flex items-center space-x-3">
                                                                <form x-data="{ liked: {{ $reply->likes->where('user_id', auth()->id())->count() > 0 ? 'true' : 'false' }}, likeCount: {{ $reply->likes->count() }} }" 
                                                                      action="{{ route('comment.like', $reply->id) }}" 
                                                                      method="POST"
                                                                      class="inline">
                                                                    @csrf
                                                                    <button type="button"
                                                                            @click="
                                                                                fetch('{{ route('comment.like', $reply->id) }}', {
                                                                                    method: 'POST',
                                                                                    headers: {
                                                                                        'Content-Type': 'application/json',
                                                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                                    },
                                                                                    credentials: 'same-origin'
                                                                                })
                                                                                .then(response => response.json())
                                                                                .then(data => {
                                                                                    liked = !liked;
                                                                                    likeCount = data.count;
                                                                                });
                                                                            "
                                                                            class="flex items-center text-gray-500 hover:text-violet-600 transition">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                                                             class="h-4 w-4 mr-1" 
                                                                             :class="liked ? 'text-violet-600 fill-violet-600' : ''"
                                                                             viewBox="0 0 20 20" 
                                                                             fill="currentColor">
                                                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2a1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                                        </svg>
                                                                        <span x-text="likeCount" :class="liked ? 'text-violet-600 font-medium' : ''" class="text-xs"></span>
                                                                    </button>
                                                                </form>
                                                                
                                                                @can('delete-comment', $reply)
                                                                    <div x-data="{ open: false }" class="relative">
                                                                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                            </svg>
                                                                        </button>
                                                                        <div x-show="open" 
                                                                            @click.away="open = false" 
                                                                            x-cloak
                                                                            x-transition:enter="transition ease-out duration-100"
                                                                            x-transition:enter-start="transform opacity-0 scale-95"
                                                                            x-transition:enter-end="transform opacity-100 scale-100"
                                                                            x-transition:leave="transition ease-in duration-75"
                                                                            x-transition:leave-start="transform opacity-100 scale-100"
                                                                            x-transition:leave-end="transform opacity-0 scale-95"
                                                                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200">
                                                                            <form action="#" method="POST">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition">
                                                                                    <div class="flex items-center">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                                                        </svg>
                                                                                        Delete Reply
                                                                                    </div>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                @endcan
                                                            </div>
                                                        @else
                                                            <div class="flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2a1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                                </svg>
                                                                <span class="text-gray-500 text-xs">{{ $reply->likes->count() }}</span>
                                                            </div>
                                                        @endauth
                                                    </div>
                                                    
                                                    <div class="mt-2 text-gray-700 text-sm">
                                                        <p>{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <p class="text-gray-600 mb-4">No comments yet. Be the first to share your thoughts!</p>
                        
                        @auth
                            @if(!$discussion->is_locked)
                                <a href="#comment-form" class="inline-flex items-center bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded-md transition shadow-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Add Comment
                                </a>
                            @endif
                        @endauth
                    </div>
                @endforelse
                <!-- Pagination -->
<div class="mt-6">
    {{ $comments->links('pagination::tailwind') }}
</div>
            </div>
        </div>
    </div>
</section>

<!-- Related Discussions -->
@if($relatedDiscussions->count() > 0)
    <section class="py-10 md:py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-xl md:text-2xl font-bold mb-6 text-gray-900">Related Discussions</h2>
                
                <div class="grid gap-4">
                    @foreach($relatedDiscussions as $relatedDiscussion)
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-sm transition border border-gray-100">
                            <a href="{{ route('forum.show', $relatedDiscussion->slug) }}" class="block">
                                <h3 class="text-lg font-bold mb-2 text-gray-900 hover:text-violet-600 transition">{{ $relatedDiscussion->title }}</h3>
                                
                                <div class="flex flex-wrap items-center text-sm text-gray-500 mb-2 gap-x-4 gap-y-1">
                                    <span class="flex items-center">
                                        <img src="{{ $relatedDiscussion->user->avatar ? Storage::url($relatedDiscussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($relatedDiscussion->user->name) }}" 
                                            alt="{{ $relatedDiscussion->user->name }}" 
                                            class="h-5 w-5 rounded-full mr-1.5 object-cover">
                                        {{ $relatedDiscussion->user->name }}
                                    </span>
                                    
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $relatedDiscussion->comments_count }}
                                    </span>
                                    
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $relatedDiscussion->view_count }}
                                    </span>
                                    
                                    @if($relatedDiscussion->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              style="background-color: {{ $relatedDiscussion->category->color }}20; color: {{ $relatedDiscussion->category->color }};">
                                            {{ $relatedDiscussion->category->name }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit(strip_tags($relatedDiscussion->content), 120) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
    </div>
    
    @push('scripts')
        <script>
            function discussion() {
                return {
                    isLiked: {{ $discussion->likes->where('user_id', auth()->id())->count() > 0 ? 'true' : 'false' }},
                    likeCount: {{ $discussion->likes->count() }},
                    toggleLike() {
                        fetch('{{ route('forum.like', $discussion->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.isLiked = !this.isLiked;
                            this.likeCount = data.count;
                        });
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>