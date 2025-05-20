<section class="relative bg-[#B3A4FF] overflow-hidden py-10 mx-auto flex lg:h-[70vh] justify-center items-center  text-white">
    {{-- Background shapes --}}
    <img src="{{ asset('assets/tips-bg.png') }}" alt="Background Decorative" class="absolute inset-0 w-full h-full object-cover object-right md:object-center lg:object-contain pointer-events-none" />

    {{-- Content --}}
    <div class="w-full max-container z-10">
        <div class="  flex flex-col md:flex-row items-center justify-center md:justify-between w-full ">
            {{-- Image (person) --}}
            <div class="w-full ">
                <img src="{{ asset('assets/tips-person.png') }}" alt="Tips Illustration" class="w-[200px] mx-auto md:mx-0 lg:w-[300px] 2xl:w-[400px]" />
            </div>
            {{-- Text --}}
            <div class="w-full flex justify-end">
                <div class="w-full">
    
                    <h2 class="text-2xl lg:text-5xl 2xl:text-6xl font-black leading-snug mb-4 text-center md:text-left">
                        Tips <span class="text-yellow-400">Menabung</span> untuk Mahasiswa
                    </h2>
                    <p class="text-white text-sm lg:text-lg mb-6 text-center md:text-left">
                        Mahasiswa juga bisa menabung. <br />
                        Simak beberapa tips sederhana yang bisa dilakukan untuk mulai menabung
                    </p>
                    <a href="#forum" class="flex md:w-fit justify-center md:justify-start bg-yellow-400 hover:bg-yellow-500 text-white font-medium py-2 px-4 rounded-md transition">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
