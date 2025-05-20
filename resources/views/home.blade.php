<x-app-layout>
    <!-- Hero Section -->
    <x-hero></x-hero>

    <!-- Features Section -->
    <x-feature></x-feature>

    <!-- Tips Section -->
    <x-tips></x-tips>

    <!-- Discussion Section -->
    <x-discussion :categorySlug="request()->category" />

    <x-floating-ai />

</x-app-layout>