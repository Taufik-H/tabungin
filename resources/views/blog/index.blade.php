<x-app-layout>
    <!-- Blog Header -->
    <section 
    class="bg-[#b4adff] h-[300px] rounded-b-[50px] text-white py-16  bg-no-repeat bg-cover bg-bottom"
    style="background-image: url('{{ asset('assets/header-bg.png') }}'); "
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 justify-center items-center mt-5">
            <div>
                <h1 class="text-3xl font-black mb-2 text-center">TabungIn Tips & Wawasan Keuangan</h1>
                <p class="text-violet-100 text-center">Baca artikel bermanfaat seputarkeuangan pribadi, investasi, menabung, dan gaya hidup</p>
            </div>

            <!-- Search Form -->
            <div class="">
                <form action="{{ route('blog.index') }}" method="GET" class="flex">
                    <input type="text" 
                           name="search" 
                           placeholder="Search articles..." 
                           value="{{ request('search') }}"
                           class="px-4 py-2 rounded-l-md border-0 focus:ring-2 focus:ring-violet-500 text-gray-900">
                    <button type="submit" class="bg-white text-violet-700 px-4 py-2 rounded-r-md hover:bg-violet-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>


    <!-- Blog Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                        <h3 class="text-lg font-bold mb-4 text-gray-900">Categories</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('blog.index') }}" class="flex items-center justify-between px-3 py-2 rounded-md {{ !request('category') ? 'bg-violet-100 text-violet-700' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                    <span>All Posts</span>
                                    <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $categories->sum('posts_count') }}</span>
                                </a>
                            </li>
                            
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-md {{ request('category') == $category->slug ? 'bg-violet-100 text-violet-700' : 'text-gray-700 hover:bg-gray-100' }} transition">
                                        <span>{{ $category->name }}</span>
                                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $category->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Filter Info -->
                    @if(request('search') || request('category'))
                        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
                            <div>
                                @if(request('search'))
                                    <span class="text-gray-700">
                                        Search results for: <span class="font-medium">{{ request('search') }}</span>
                                    </span>
                                @endif
                                
                                @if(request('category'))
                                    <span class="text-gray-700">
                                        Category: <span class="font-medium">{{ $categories->where('slug', request('category'))->first()->name ?? '' }}</span>
                                    </span>
                                @endif
                            </div>
                            
                            <a href="{{ route('blog.index') }}" class="text-sm text-violet-600 hover:text-violet-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Clear filters
                            </a>
                        </div>
                    @endif
                    
                    <!-- Posts Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($posts as $post)
                            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    @if($post->featured_image)
                                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="p-5 flex-grow flex flex-col">
                                    <div class="mb-2">
                                        @if($post->category)
                                            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" 
                                               class="inline-block px-3 py-1 rounded-full text-xs font-medium"
                                               style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                                {{ $post->category->name }}
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-lg font-bold mb-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 hover:text-violet-600 transition">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 flex-grow">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                        <div class="flex items-center">
                                            <img src="{{ $post->user->avatar ? Storage::url($post->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                                                alt="{{ $post->user->name }}" 
                                                class="h-6 w-6 rounded-full mr-2">
                                            <span class="text-xs text-gray-600">{{ $post->user->name }}</span>
                                        </div>
                                        
                                        <span class="text-xs text-gray-500">{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 bg-white rounded-lg p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No posts found</h3>
                                <p class="text-gray-600 mb-4">{{ request('search') || request('category') ? 'Try changing your search or filter criteria.' : 'New posts will be published soon.' }}</p>
                                <a href="{{ route('blog.index') }}" class="inline-flex items-center text-violet-600 hover:text-violet-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Back to all posts
                                </a>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>