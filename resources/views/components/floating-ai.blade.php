<div x-data="{ showTooltip: true }" x-init="setTimeout(() => showTooltip = false, 5000)" class="fixed bottom-6 right-6 z-50">
    <button
        @click="window.location.href='/chat'"
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
        class="w-16 h-16 rounded-full shadow-lg bg-white flex items-center justify-center transition hover:scale-105 focus:outline-none border border-gray-200 relative group"
        style="box-shadow: 0 4px 24px 0 rgba(0,0,0,0.10);"
        aria-label="Tanya Aira"
    >
        <img src="/assets/logo.png" alt="Aira Logo" class="w-12 h-12 object-contain" />
        <span
            x-show="showTooltip"
            x-transition.opacity.duration.300ms
            class="absolute right-20 top-1/2 -translate-y-1/2 bg-white text-[#b4adff] font-bold px-3 py-1 rounded-full shadow-lg whitespace-nowrap pointer-events-none select-none"
            style="min-width: 90px;"
        >Tanya Aira</span>
    </button>
</div>
