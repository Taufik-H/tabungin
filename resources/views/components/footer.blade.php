<footer class="text-white " style="background-image: url('{{ asset('assets/footer-bg.png') }}'); background-size: cover; background-position: center;">
    <div class="container mx-auto py-10 grid grid-cols-1 md:grid-cols-3 gap-8 max-container items-center lg:h-[30vh]">

        <!-- Kiri: Logo & Deskripsi -->
        <div>
            <div class="flex items-center mb-4">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full mr-2">
                <div>
                    <h2 class="font-bold text-lg">TabungIn</h2>
                    <p class="text-sm">Teman Cerdas Keuanganmu</p>
                </div>
            </div>
            <p class="text-sm leading-relaxed">
                Sebuah Platform yang memberikan rekomendasi finansial cerdas lewat Chat AI. Diskusi bareng komunitas, dan baca artikel keuangan terpercaya
            </p>
        </div>

        <!-- Tengah: Navigasi -->
        <div>
            <h2 class="font-bold mb-3">TabungIn</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="#home" class="hover:underline">Beranda</a></li>
                <li><a href="#feature" class="hover:underline">Fitur</a></li>
                <li><a href="{{ url('/blog') }}" class="hover:underline">Blog</a></li>
                <li><a href="{{ url('/tentang') }}" class="hover:underline">Tentang</a></li>
            </ul>
        </div>

        <!-- Kanan: Kontak & Sosial Media -->
        <div>
            <h2 class="font-bold mb-3">Hubungi Kami</h2>
            <p class="text-sm">Jl. Setu Indah No.116, Tugu, Kec. Cimanggis, Kota Depok, Jawa Barat 16451</p>
            <p class="text-sm mt-2">Phone: 08123456789</p>
            <p class="text-sm">Email: help@tabungin.id</p>

            <div class="flex space-x-4 mt-4">
                <a href="#" aria-label="Instagram">
                    <img src="{{ asset('assets/ig-icon.png') }}" alt="Instagram" class="w-5 h-5">
                </a>
                <a href="#" aria-label="X (Twitter)">
                    <img src="{{ asset('assets/x-icon.png') }}" alt="X" class="w-5 h-5">
                </a>
                <a href="#" aria-label="YouTube">
                    <img src="{{ asset('assets/yt-icon.png') }}" alt="YouTube" class="w-5 h-5">
                </a>
                <a href="#" aria-label="LinkedIn">
                    <img src="{{ asset('assets/linkedin-icon.png') }}" alt="LinkedIn" class="w-5 h-5">
                </a>
            </div>
        </div>
    </div>

    <!-- Bawah -->
    <div class="text-center py-4 text-sm bg-[#C7BFFF] text-white">
        Copyright <span class="font-semibold ">Tabungin.id</span> All Rights Reserved, 2025
    </div>
</footer>
