@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();

    $menus = [
        ['label' => 'Beranda', 'url' => '/'],
        ['label' => 'Fitur', 'url' => '/#feature'],
        ['label' => 'Blog', 'url' => url('/blog')],
        ['label' => 'Tentang', 'url' => url('/about')],
    ];
@endphp

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
  [x-cloak] { display: none !important; }
  
  .nav-link {
    position: relative;
  }
  
  .nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -4px;
    left: 0;
    background-color: white;
    transition: width 0.3s ease;
  }
  
  .nav-link:hover::after {
    width: 100%;
  }
  
  .mobile-menu-enter {
    transform: translateY(-10px);
    opacity: 0;
  }
  
  .mobile-menu-enter-active {
    transition: all 0.3s ease;
  }
  
  .mobile-menu-enter-to {
    transform: translateY(0);
    opacity: 1;
  }
  
  .mobile-menu-leave {
    transform: translateY(0);
    opacity: 1;
  }
  
  .mobile-menu-leave-active {
    transition: all 0.3s ease;
  }
  
  .mobile-menu-leave-to {
    transform: translateY(-10px);
    opacity: 0;
  }
</style>

<div x-data="{ isOpen: false, userDropdownOpen: false }" class="relative">
    <!-- Navbar -->
    <nav class="bg-[#b4adff] py-3 px-6 md:px-10 lg:px-20 flex justify-between items-center fixed top-0 w-full z-50 ">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-8 h-8 md:w-10 md:h-10 rounded-full">
            <span class="text-white font-bold text-base md:text-lg">TabungIn</span>
        </div>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 lg:space-x-8 text-white font-medium">
            @foreach ($menus as $menu)
                <li>
                    <a href="{{ $menu['url'] }}" class="nav-link hover:text-gray-100 transition-colors">
                        {{ $menu['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Right Section -->
        <div class="flex items-center space-x-2 md:space-x-4">
            <!-- User / Auth -->
            @if ($user)
                <div class="relative hidden md:block">
                    <button @click="userDropdownOpen = !userDropdownOpen" 
                            @keydown.escape="userDropdownOpen = false"
                            class="flex items-center gap-1 md:gap-2 focus:outline-none">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                     class="w-7 h-7 md:w-8 md:h-8 rounded-full object-cover border border-white">
                            @else
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-600 font-semibold text-sm">
                                        {{ $user ? substr($user->name, 0, 2) : 'U' }}
                                    </span>
                                </div>
                            @endif
                        <span class="text-white font-semibold text-sm md:text-base hidden sm:inline">{{ $user->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="userDropdownOpen" 
                         x-cloak 
                         @click.away="userDropdownOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg z-50 py-1 overflow-hidden">
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Profile</span>
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Logout</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="hidden md:flex space-x-4  items-center">
                    <a href="{{ route('login') }}" class="text-white bg-amber-500 rounded-full px-4 py-1.5 font-semibold hover:text-gray-100 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="border border-white text-white px-4 py-1.5 rounded-full font-semibold hover:text-violet-500 hover:bg-gray-100 transition-colors">Daftar</a>
                </div>
            @endif

            <!-- Hamburger / X Icon -->
            <button @click="isOpen = !isOpen" 
                    @keydown.escape="isOpen = false"
                    class="md:hidden text-white focus:outline-none p-1.5 rounded-md hover:bg-[#a399ff] transition-colors"
                    aria-label="Toggle menu">
                <!-- Hamburger Icon -->
                <svg x-show="!isOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <!-- X Icon -->
                <svg x-show="isOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Dropdown -->
    <div x-show="isOpen" 
         x-cloak 
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden fixed top-[56px] sm:top-[64px] left-0 right-0 bg-[#b4adff] py-4 px-6 z-40 shadow-lg border-t border-[#a399ff]">
        <ul class="space-y-3 text-white font-medium">
            @foreach ($menus as $menu)
                <li>
                    <a href="{{ $menu['url'] }}" class="block py-2 hover:bg-[#a399ff] px-3 rounded-md transition-colors">
                        {{ $menu['label'] }}
                    </a>
                </li>
            @endforeach

            @if ($user)
                <li class="border-t border-[#a399ff] pt-2 mt-2">
                    <a href="{{ url('/profile') }}" class="block py-2 hover:bg-[#a399ff] px-3 rounded-md transition-colors">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profile</span>
                        </div>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 px-3 bg-white text-[#b4adff] rounded-md font-medium hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </li>
            @else
                <li class="border-t border-[#a399ff] pt-2 mt-2">
                <a href="{{ route('login') }}" class="text-white bg-amber-500 rounded-md px-4 py-1.5 w-full  flex font-semibold hover:text-gray-100 transition-colors">Masuk</a>
            </li>
            <li>
                    <a href="{{ route('register') }}" class="border border-white text-white px-4 py-1.5 rounded-md flex  w-full font-semibold hover:text-violet-500 hover:bg-gray-100 transition-colors">Daftar</a>
                   
                </li>
            @endif
        </ul>
    </div>
</div>

<!-- Spacer to prevent content from being hidden under fixed navbar -->
<!-- <div class="h-[56px] sm:h-[64px]"></div> -->