@php
    $features = [
        [
            'title' => 'Chat AI',
            'description' => 'Aira, Asisten Chat yang akan membantu pengguna untuk merekomendasikan seputar keuangan',
            'icon' => 'assets/icons/chat-ai.png',
            'href' => '/chat',
            
        ],
        [
            'title' => 'Blog',
            'description' => 'wadah untuk menyajikan konten informatif, edukatif, dan inspiratif yang berkaitan dengan pengelolaan keuangan pribadi.',
            'icon' => 'assets/icons/blog.png',
            'href' => '/blog',
        ],
        [
            'title' => 'Forum',
            'description' => 'saling berbagi pengalaman, tips, dan diskusi seputar pengelolaan keuangan secara interaktif dan sosial melalui platform TabungIn.',
            'icon' => 'assets/icons/forum.png',
            'href' => '/forum',
        ],
    ];
@endphp

<section id="feature" class="py-16 bg-white max-container lg:h-[70vh] flex justify-center items-center mx-auto">
    <div class="mx-auto">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-10">Fitur yang kami tawarkan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-10">
            @foreach ($features as $feature)
                <x-feature-card
                    :title="$feature['title']"
                    :description="$feature['description']"
                    :icon="$feature['icon']"
                    :href="$feature['href']"
                    
                />
            @endforeach
        </div>
    </div>
</section>
