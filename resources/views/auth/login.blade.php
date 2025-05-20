<x-guest-layout>
    <div class="flex h-screen w-full">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 bg-gray-100">
            <img src="{{ asset('images/login-image.jpg') }}" alt="Login" class="h-full w-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1579547945413-497e1b99dac0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';this.onerror='';">
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
                    <p class="mt-2 text-gray-600">Please sign in to your account</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                            @if (Route::has('password.request'))
                                <a class="text-xs text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center py-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                    @if (Route::has('register'))
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            {{ __("Don't have an account?") }} 
                            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Register') }}
                            </a>
                        </p>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
