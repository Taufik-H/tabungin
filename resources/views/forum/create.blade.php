<x-app-layout>
    <!-- Page Header -->
    <section 
    class="bg-[#b4adff] h-[300px]  rounded-b-[50px] text-white py-10 md:py-12 bg-no-repeat bg-cover bg-center"
    style="background-image: url('{{ asset('assets/header-bg.png') }}');"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <div class="flex flex-col justify-center items-center gap-3">
            <div class="mb-6 md:mb-0 text-center">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Buat Topik Diskusi</h1>
                <p class="text-violet-100 text-sm md:text-base">Bagikan diskusi dan mulai berinteraksi dengan para ahli</p>
            </div>

           
        </div>
    </div>
</section>

    <!-- Form Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <form action="{{ route('forum.store') }}" method="POST">
                        @csrf
                        
                        @if($errors->any())
                            <div class="mb-6 bg-danger-50 text-danger-700 p-4 rounded-md">
                                <ul class="list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50"
                                   placeholder="Diskusi anda tentang apa?"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Buatlah spesifik dan bayangkan Anda sedang mengajukan pertanyaan kepada orang lain.</p>
                        </div>
                        
                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi</label>
                            <textarea id="content" 
                                      name="content" 
                                      rows="12" 
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-violet-300 focus:ring focus:ring-violet-200 focus:ring-opacity-50"
                                      placeholder="Berikan detail tentang topik diskusi anda..."
                                      required>{{ old('content') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">
                            Anda dapat menggunakan Markdown untuk memformat isi Anda. Pelajari lebih lanjut tentang Markdown. 
                                <a href="https://www.markdownguide.org/basic-syntax/" target="_blank" class="text-violet-600 hover:text-violet-800">Pelajari lebih lanjut tentang markdown</a>
                            </p>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('forum.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-md transition">
                                Batal
                            </a>
                            <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded-md transition">
                                Buat Diskusi
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tips membuat diskusi yang kuat</h3>
                    
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span> Gunakan judul yang jelas dan deskriptif yang merangkum inti atau pertanyaan utama Anda.</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span> Sertakan konteks dan informasi latar belakang dalam postingan Anda.</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span> Jelaskan secara spesifik apa yang ingin Anda tanyakan atau diskusikan.</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Pilih kategori yang sesuai agar orang lain mudah menemukan diskusi Anda.</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Formatlah postingan Anda agar mudah dibaca dengan paragraf, daftar, dan heading.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>