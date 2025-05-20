<x-guest-layout>
    <div class="flex h-screen w-full">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/2 bg-gray-100">
            <img src="{{ asset('images/verify-email-image.jpg') }}" alt="Verify Email" class="h-full w-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1596526131083-e8c633c948d2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';this.onerror='';">
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold text-gray-800">Verify Your Email</h1>
                    <p class="mt-2 text-gray-600">One last step to complete your registration</p>
                </div>

                <div class="mb-6 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 rounded-lg">
                        <p class="text-sm font-medium text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </p>
                    </div>
                @endif

                <div class="mt-6 space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf
                        <x-primary-button class="w-full justify-center py-3">
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="w-full text-center mt-4">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
