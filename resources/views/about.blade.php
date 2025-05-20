<x-app-layout>
<div class="min-h-screen ">
<section 
    class="bg-[#b4adff] h-[300px]  rounded-b-[50px] text-white py-10 md:py-12 bg-no-repeat bg-cover bg-center"
  
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <div class="flex flex-col justify-center items-center gap-3">
            <div class="mb-6 md:mb-0 text-center">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Apa itu TabungIn ?</h1>
                <p class="text-accent-100 text-sm md:text-base lg:w-[800px] text-center p-6"> TabungIn adalah platform keuangan digital yang membantu pengguna 
                menabung, mengelola uang, dan belajar keuangan melalui AI chatbot, 
                komunitas diskusi, dan blog edukatif. Dengan tampilan yang simpel dan fitur 
                yang cerdas, TabungIN hadir sebagai sahabat finansial generasi digital</p>
            </div>

        
        </div>
    </div>
</section>
    <!-- Vision Section -->
     <div class="relative  overflow-hidden py-20 mx-auto flex lg:h-[80vh] justify-center items-center  text-white"  >
     <img src="{{ asset('assets/visi.png') }}" alt="Background Decorative" class="absolute inset-0 w-full h-full object-cover object-right lg:object-center lg:object-contain pointer-events-none" />
     <div class="z-10">
         <section class="max-w-4xl mx-auto px-4 mb-12">
             <div class="bg-[#C8AED5] rounded-3xl p-8 relative overflow-hidden">
                 
                 <h2 class="text-2xl font-semibold text-white mb-4">Visi</h2>
                 <p class="text-white text-xl italic text-center">
                     "Mewujudkan generasi yang cerdas finansial dan berdaya melalui teknologi."
                    </p>
                </div>
            </section>
            
            <!-- Mission Section -->
            <section class="max-w-4xl mx-auto px-4 mb-12">
        <div class="bg-[#C8AED5] rounded-3xl p-8 relative overflow-hidden">
            
            <h2 class="text-2xl font-semibold text-white mb-4">Misi</h2>
            <ul class="text-white space-y-3 pl-6">
                <li class="relative before:content-['•'] before:absolute before:-left-6 before:text-white">
                    Menyediakan rekomendasi keuangan yang mudah diakses dan dipersonalisasi.
                </li>
                <li class="relative before:content-['•'] before:absolute before:-left-6 before:text-white">
                    Membangun komunitas edukatif yang suportif dan terbuka.
                </li>
                <li class="relative before:content-['•'] before:absolute before:-left-6 before:text-white">
                    Menyediakan konten edukatif yang relevan dan terpercaya.
                </li>
            </ul>
        </div>
    </section>
</div>    
</div>

    <!-- Benefits Section -->
    <section class="py-16 " style="background-image: url('{{ asset('assets/footer-bg.png') }}'); background-size: cover; background-position: center;">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-semibold text-white mb-8 text-center">Manfaat Menggunakan TabungIn</h2>
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="lg:w-2/5">
                    <img src="{{ asset('assets/hand-plant-coins.png') }}" alt="Ilustrasi Tabungin" class="w-full rounded-lg">
                </div>
                <div class="lg:w-3/5 space-y-6">
                    <div class="flex items-start">
                        <span class="text-white mr-2">•</span>
                        <p class="text-white font-medium">Inklusif – Terbuka untuk semua, tanpa batasan pengetahuan keuangan.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-white mr-2">•</span>
                        <p class="text-white font-medium">Edukatif – Mengutamakan pembelajaran, bukan hanya angka.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-white mr-2">•</span>
                        <p class="text-white font-medium">Interaktif – Komunitas dan AI bekerja bersama untuk membimbing pengguna.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-white mr-2">•</span>
                        <p class="text-white font-medium">Aman dan Andal – Data pengguna adalah prioritas utama.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 px-4 bg-[#E8AFE3]">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <div class="bg-[#F0E7FD]  rounded-3xl p-6 text-center">
                        <h2 class="text-2xl font-semibold text-violet-500 mb-6">Tentang Kami</h2>
                        <div class="flex flex-col items-center mb-6">
                            <img src="{{ asset('assets/logo.png') }}" alt="TabungIn Logo" class="w-24 h-24 mb-3">
                            <h3 class="text-xl font-semibold text-violet-500">TabungIn</h3>
                        </div>
                      
                    </div>
                </div>
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-semibold text-white mb-6">Frequently Asked Question</h2>
                    <div class="space-y-4">
                        <div class="border-b border-white overflow-hidden">
                            <button class="w-full text-left p-4 text-white font-medium flex justify-between items-center" 
                                    onclick="toggleAccordion('faq1')">
                                Apakah TabungIn gratis digunakan?
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-200" id="faq1-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden p-4 pt-0 text-white" id="faq1-content">
                                Ya! tabungin bisa digunakan secara gratis.
                            </div>
                        </div>
                        <div class="border-b border-white overflow-hidden">
                            <button class="w-full text-left p-4 text-white font-medium flex justify-between items-center" 
                                    onclick="toggleAccordion('faq2')">
                                Bagaimana cara mulai menggunakan TabungIn?
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-200" id="faq2-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden p-4 pt-0 text-white" id="faq2-content">
                               Lakukan pendaftaran terlebih dahulu, setelah itu anda dapat langsung menggunakan tabungin seperti membuat forum diskusi pada menu forum.
                            </div>
                        </div>
                        <div class="border-b border-white overflow-hidden">
                            <button class="w-full text-left p-4 text-white font-medium flex justify-between items-center" 
                                    onclick="toggleAccordion('faq3')">
                                Saya mengalami masalah teknis, ke mana saya harus menghubungi?
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-200" id="faq3-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden p-4 pt-0 text-white" id="faq3-content">
                               Anda dapat langsung menghubungi kami lewat contact tertera pada footer.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    
</div>
<script>
    function toggleAccordion(id) {
        const content = document.getElementById(`${id}-content`);
        const icon = document.getElementById(`${id}-icon`);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
</x-app-layout>