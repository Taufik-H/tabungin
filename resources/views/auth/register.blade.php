<x-guest-layout>
    <div class="flex h-screen w-full">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 bg-gray-100">
            <img src="{{ asset('images/register-image.jpg') }}" alt="Register" class="h-full w-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';this.onerror='';">
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>
                    <p class="mt-2 text-gray-600">Join us today and get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-gray-700" />
                        <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex flex-col space-y-4">
                        <x-primary-button class="w-full justify-center py-3">
                            {{ __('Register') }}
                        </x-primary-button>
                        
                        <div class="text-center">
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                {{ __('Already have an account? Sign in') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
