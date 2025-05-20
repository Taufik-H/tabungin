<x-guest-layout>
    <div class="flex h-screen w-full">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 bg-gray-100">
            <img src="{{ asset('images/confirm-password-image.jpg') }}" alt="Confirm Password" class="h-full w-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1614064641938-3bbee52942c7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';this.onerror='';">
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-800">Security Check</h1>
                    <p class="mt-2 text-gray-600">Please confirm your password</p>
                </div>

                <div class="mb-6 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex flex-col space-y-4">
                        <x-primary-button class="w-full justify-center py-3">
                            {{ __('Confirm') }}
                        </x-primary-button>
                        
                        <div class="text-center">
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                {{ __('Cancel and return to login') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
