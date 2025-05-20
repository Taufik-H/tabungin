<x-app-layout>
    <div class="max-container px-4 py-10 sm:px-6 lg:px-8 mx-auto">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7  border shadow">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800">Profile</h2>
                <p class="text-sm text-gray-600">
                    Kelola akun dan profile anda.
                </p>
            </div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                    <!-- Avatar -->
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5">
                            Foto profile
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="flex items-center gap-5">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}"
                                     alt="{{ $user->name }}"
                                     class="inline-block size-16 rounded-full ring-2 ring-white object-cover" />
                            @else
                                <div class=" size-16 rounded-full bg-gray-200 flex items-center justify-center text-2xl text-gray-500">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <input type="file"
                                       name="avatar"
                                       id="avatar"
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" />
                                @error('avatar')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="sm:col-span-3">
                        <label for="name" class="inline-block text-sm text-gray-800 mt-2.5">
                            Nama
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <x-text-input id="name" name="name" type="text"
                            class="mt-1 block w-full"
                            :value="old('name', $user->name)"
                            required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div class="sm:col-span-3">
                        <label for="email" class="inline-block text-sm text-gray-800 mt-2.5">
                            Email
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <x-text-input id="email" name="email" type="email"
                            class="mt-1 block w-full"
                            :value="old('email', $user->email)"
                            required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Submit Button -->
                    <div class="sm:col-span-12 mt-6 flex items-center gap-4">
                        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >Tersimpan.</p>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Password Form -->
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 mt-10 border shadow">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Form -->
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 mt-10 border shadow">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
