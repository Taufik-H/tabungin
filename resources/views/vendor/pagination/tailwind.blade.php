@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mt-6">
        <div class="text-sm text-gray-600 ">
            {!! __('Menampilkan') !!}
            @if ($paginator->firstItem())
                <span class="font-medium text-purple-700 ">{{ $paginator->firstItem() }}</span>
                {!! __('hingga') !!}
                <span class="font-medium text-purple-700 ">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('dari') !!}
            <span class="font-medium text-purple-700 ">{{ $paginator->total() }}</span>
            {!! __('data') !!}
        </div>

        <div class="inline-flex items-center gap-1.5">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 text-sm rounded-lg bg-gray-100  text-gray-400  cursor-not-allowed flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {{ __('Sebelumnya') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-sm rounded-lg bg-white  text-gray-700 border border-gray-200  hover:bg-gray-50  hover:text-purple-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    {{ __('Sebelumnya') }}
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="hidden sm:flex items-center gap-1.5">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3.5 py-2 text-sm text-gray-500 ">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3.5 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3.5 py-2 text-sm rounded-lg bg-white  text-gray-700 border border-gray-200  hover:bg-gray-50  hover:text-purple-700  transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-sm rounded-lg bg-white  text-gray-700 border border-gray-200  hover:bg-gray-50    transition-colors flex items-center">
                    {{ __('Berikutnya') }}
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <span class="px-3 py-2 text-sm rounded-lg bg-gray-100  text-gray-400  cursor-not-allowed flex items-center">
                    {{ __('Berikutnya') }}
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif