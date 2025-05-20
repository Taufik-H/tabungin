<x-app-layout>
    <!-- Forum Header with Gradient Background -->
    <section 
    class="bg-[#b4adff] h-[300px]  rounded-b-[50px] text-white py-10 md:py-12 bg-no-repeat bg-cover bg-center"
    style="background-image: url('{{ asset('assets/header-bg.png') }}');"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <div class="flex flex-col justify-center items-center gap-3">
            <div class="mb-6 md:mb-0 text-center">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Discussion Forum</h1>
                <p class="text-accent-100 text-sm md:text-base">Connect with the community and share your thoughts</p>
            </div>

            <div class="flex flex-col gap-3 sm:gap-2">
                
                <!-- Search Form -->
                <form action="{{ route('forum.index') }}" method="GET" class="flex w-full sm:w-auto">
                    <div class="relative flex-grow">
                        <input type="text" 
                        name="search" 
                        placeholder="Search discussions..." 
                        value="{{ request('search') }}"
                            class="px-4 py-2.5 rounded-l-md border-0 focus:ring-2 focus:ring-accent-500 text-gray-900 w-full shadow-sm">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    </div>
                    <button type="submit" class="bg-amber-500 text-accent-700 px-4 py-2.5 rounded-r-md hover:bg-accent-100 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('forum.create') }}" class="bg-amber-500 text-accent-700 hover:bg-accent-100 px-4 py-2.5 rounded-md inline-flex items-center justify-center transition shadow-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Discussion
                </a>
            </div>
        </div>
    </div>
</section>


    <!-- Forum Content -->
    <section class="py-8 md:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1 order-2 lg:order-1">
                    <div class="bg-white rounded-lg shadow-sm p-5 lg:sticky lg:top-24">
                        <!-- Categories Section -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-900">Categories</h3>
                                <span class="text-xs text-gray-500 font-medium">{{ $categories->sum('discussions_count') }} Discussions</span>
                            </div>
                            
                            <ul class="space-y-1.5">
                                <li>
                                    <a href="{{ route('forum.index', ['sort' => request('sort'), 'search' => request('search')]) }}" 
                                       class="flex items-center justify-between px-3 py-2.5 rounded-md {{ !request('category') ? 'bg-accent-100 text-accent-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                        <span>All Discussions</span>
                                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded-full">{{ $categories->sum('discussions_count') }}</span>
                                    </a>
                                </li>
                                
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('forum.index', ['category' => $category->slug, 'sort' => request('sort'), 'search' => request('search')]) }}" 
                                           class="flex items-center justify-between px-3 py-2.5 rounded-md {{ request('category') == $category->slug ? 'bg-accent-100 text-accent-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                            <div class="flex items-center">
                                                @if($category->icon)
                                                    <span class="mr-2 text-{{ $category->color ?? 'gray' }}-500">
                                                        {!! $category->icon !!}
                                                    </span>
                                                @endif
                                                <span>{{ $category->name }}</span>
                                            </div>
                                            <span class="bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded-full">{{ $category->discussions_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <!-- Sort By Section -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-gray-900">Sort By</h3>
                            <ul class="space-y-1.5">
                                <li>
                                    <a href="{{ route('forum.index', array_merge(request()->query(), ['sort' => 'latest'])) }}" 
                                       class="flex items-center px-3 py-2.5 rounded-md {{ (!request('sort') || request('sort') == 'latest') ? 'bg-accent-100 text-accent-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Latest
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('forum.index', array_merge(request()->query(), ['sort' => 'popular'])) }}" 
                                       class="flex items-center px-3 py-2.5 rounded-md {{ request('sort') == 'popular' ? 'bg-accent-100 text-accent-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        Most Viewed
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('forum.index', array_merge(request()->query(), ['sort' => 'most_comments'])) }}" 
                                       class="flex items-center px-3 py-2.5 rounded-md {{ request('sort') == 'most_comments' ? 'bg-accent-100 text-accent-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        Most Comments
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('forum.index', array_merge(request()->query(), ['sort' => 'most_likes'])) }}" 
                                       class="flex items-center px-3 py-2.5 rounded-md {{ request('sort') == 'most_likes' ? 'bg-accent-100 text-accent-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                        </svg>
                                        Most Liked
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="lg:col-span-3 order-1 lg:order-2">
                    <!-- Filter Info -->
                    @if(request('search') || request('category') || request('sort'))
                        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex flex-wrap items-center justify-between">
                            <div class="flex flex-wrap items-center gap-2 mb-2 sm:mb-0">
                                @if(request('search'))
                                    <div class="inline-flex items-center bg-accent-50 text-accent-700 px-3 py-1.5 rounded-full text-sm">
                                        <span class="mr-1 text-gray-600">Search:</span>
                                        <span class="font-medium">{{ request('search') }}</span>
                                        <a href="{{ route('forum.index', ['category' => request('category'), 'sort' => request('sort')]) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                
                                @if(request('category'))
                                    <div class="inline-flex items-center bg-accent-50 text-accent-700 px-3 py-1.5 rounded-full text-sm">
                                        <span class="mr-1 text-gray-600">Category:</span>
                                        <span class="font-medium">{{ $categories->where('slug', request('category'))->first()->name ?? '' }}</span>
                                        <a href="{{ route('forum.index', ['search' => request('search'), 'sort' => request('sort')]) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                                
                                @if(request('sort') && request('sort') != 'latest')
                                    <div class="inline-flex items-center bg-accent-50 text-accent-700 px-3 py-1.5 rounded-full text-sm">
                                        <span class="mr-1 text-gray-600">Sort:</span>
                                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', request('sort'))) }}</span>
                                        <a href="{{ route('forum.index', ['search' => request('search'), 'category' => request('category')]) }}" class="ml-2 text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('forum.index') }}" class="text-sm text-accent-600 hover:text-accent-800 flex items-center font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Clear all filters
                            </a>
                        </div>
                    @endif
                    
                    <!-- Discussions List -->
                    <div class="space-y-4">
                        @forelse($discussions as $discussion)
                            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition relative {{ $discussion->is_pinned ? 'border-l-4 border-accent-500' : '' }}">
                                @if($discussion->is_pinned)
                                    <div class="absolute top-0 left-0 bg-accent-500 text-white text-xs px-2 py-1 rounded-br-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Pinned
                                    </div>
                                @endif
                                
                                @if($discussion->is_locked)
                                    <div class="absolute top-0 right-0 bg-gray-500 text-white text-xs px-2 py-1 rounded-bl-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                        Locked
                                    </div>
                                @endif
                                
                                <div class="p-5 sm:p-6">
                                    <div class="flex items-start">
                                        <div class="hidden sm:block flex-shrink-0">
                                            <img src="{{ $discussion->user->avatar ? Storage::url($discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}" 
                                                alt="{{ $discussion->user->name }}" 
                                                class="h-12 w-12 rounded-full mr-4 object-cover border border-gray-200">
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                @if($discussion->category)
                                                    <a href="{{ route('forum.index', ['category' => $discussion->category->slug]) }}" 
                                                      class="inline-block px-3 py-1 rounded-full text-xs font-medium"
                                                      style="background-color: {{ $discussion->category->color }}20; color: {{ $discussion->category->color }};">
                                                        {{ $discussion->category->name }}
                                                    </a>
                                                @endif
                                                
                                                @if($discussion->is_locked)
                                                    <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Locked
                                                    </span>
                                                @endif
                                                
                                                @if($discussion->is_solved)
                                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Solved
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <h3 class="text-lg sm:text-xl font-bold mb-2 line-clamp-2">
                                                <a href="{{ route('forum.show', $discussion->slug) }}" class="text-gray-900 hover:text-accent-600 transition">
                                                    {{ $discussion->title }}
                                                </a>
                                            </h3>
                                            
                                            <p class="text-gray-600 mb-4 line-clamp-2 text-sm sm:text-base">
                                                {{ Str::limit(strip_tags($discussion->content), 150) }}
                                            </p>
                                            
                                            <div class="flex flex-wrap items-center justify-between text-sm text-gray-500">
                                                <div class="flex items-center flex-wrap gap-4">
                                                    <div class="flex items-center">
                                                        <img src="{{ $discussion->user->avatar ? Storage::url($discussion->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}" 
                                                            alt="{{ $discussion->user->name }}" 
                                                            class="sm:hidden h-5 w-5 rounded-full mr-1.5">
                                                        <span class="font-medium text-gray-700">{{ $discussion->user->name }}</span>
                                                    </div>
                                                    <span class="text-gray-500">{{ $discussion->created_at->diffForHumans() }}</span>
                                                </div>
                                                
                                                <div class="flex items-center gap-4 mt-2 md:mt-0">
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span>{{ $discussion->view_count }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span>{{ $discussion->comments_count }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                                        </svg>
                                                        <span>{{ $discussion->likes_count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No discussions found</h3>
                                <p class="text-gray-600 mb-6">{{ request('search') || request('category') ? 'Try changing your search or filter criteria.' : 'Be the first to start a discussion!' }}</p>
                                <div class="flex flex-wrap justify-center gap-3">
                                    @if(request('search') || request('category'))
                                        <a href="{{ route('forum.index') }}" class="inline-flex items-center text-accent-600 hover:text-accent-800 px-4 py-2 border border-accent-200 rounded-md bg-white hover:bg-accent-50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                            </svg>
                                            All discussions
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('forum.create') }}" class="inline-flex items-center bg-accent-600 hover:bg-accent-700 text-white py-2 px-4 rounded-md transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Start a discussion
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($discussions->hasPages())
                        <div class="mt-8">
                            {{ $discussions->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>