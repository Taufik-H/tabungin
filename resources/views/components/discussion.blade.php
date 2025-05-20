<div class="max-container py-20">
    <!-- Header Section with Title and Filter -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Forum Diskusi</h1>
            <p class="text-gray-600 mt-1">Temukan dan bagikan pengetahuan bersama komunitas</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
                <label for="category" class="text-sm font-medium text-gray-700 whitespace-nowrap hidden md:inline">
                    Filter:
                </label>
                <div class="relative w-full md:w-auto">
                    <select 
                        name="category" 
                        id="category" 
                        onchange="this.form.submit()" 
                        class="w-full md:w-auto pl-3 pr-10 py-2.5 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 rounded-lg shadow-sm appearance-none bg-white"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ $selectedCategory == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Discussions Grid - Limited to 6 per page -->
    @if($discussions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($discussions->take(6) as $discussion)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <!-- User and Category Info -->
                        <div class="flex items-center mb-3">
                            @if($discussion->user && $discussion->user->avatar)
                                <img src="{{ asset('storage/' . $discussion->user->avatar) }}" alt="{{ $discussion->user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                            @else
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-600 font-semibold text-sm">
                                        {{ $discussion->user ? substr($discussion->user->name, 0, 2) : 'U' }}
                                    </span>
                                </div>
                            @endif
                            
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ $discussion->user ? $discussion->user->name : 'Anonymous' }}
                                </p>
                                <div class="flex items-center text-xs text-gray-500">
                                    <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                    @if($discussion->category)
                                        <span class="mx-1.5">•</span>
                                        <span class="px-2 py-0.5 bg-purple-100 text-purple-800 rounded-full">
                                            {{ $discussion->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discussion Content -->
                        <h3 class="text-lg font-bold mb-2 text-gray-800 line-clamp-2">
                            <a href="{{ route('forum.show', $discussion->slug) }}" class="hover:text-purple-600 transition-colors">
                                {{ $discussion->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-3">
                            {{ Str::limit(strip_tags($discussion->content), 150) }}
                        </p>
                        
                        <!-- Footer with Stats -->
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center text-sm text-gray-500">
                                <div class="flex items-center mr-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span>{{ $discussion->comments_count ?? 0 }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>{{ $discussion->view_count ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('forum.show', $discussion->slug) }}" class="inline-flex items-center text-purple-600 hover:text-purple-800 text-sm font-medium">
                                Baca
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
       <div class=" flex justify-center lg:justify-between  w-full items-center">

           <div class="mt-3 md:mt-8 w-full">
               {{ $discussions->withQueryString()->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada diskusi</h3>
            <p class="text-gray-600">Tidak ada diskusi yang ditemukan untuk kategori ini</p>
        </div>
    @endif
</div>