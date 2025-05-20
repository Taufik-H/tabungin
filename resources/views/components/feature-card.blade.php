@props(['title', 'description', 'icon', 'href'])

<a href="{{ $href }}" class="block p-5 lg:p-10 rounded-xl text-center bg-pink-200 transition-shadow hover:shadow-lg ">
    <div class="flex justify-center mb-4 ">
        <img src="{{ asset($icon) }}" alt="{{ $title }} Icon" class="w-10 lg:w-20 h-10 lg:h-20 object-cover">
    </div>
    <h3 class="font-bold text-lg mb-2 my-5 lg:my-10">{{ $title }}</h3>
    <p class="text-sm text-gray-700 ">{{ $description }}</p>
</a>
