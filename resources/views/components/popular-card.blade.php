<a href="{{ route('blog.show', $item->slug) }}" class="relative rounded-lg overflow-hidden shadow-lg group">
    <img src="{{ imageOrDefault($item->media?->first()?->url, 'card') }}" alt="{{ $item->title }}"
        class="w-full h-64 object-cover transition-transform group-hover:scale-105">
    <div class="absolute inset-0 bg-black/50 flex flex-col justify-end p-4">

        <!-- Info -->
        <div class="transition-all duration-300 group-hover:-translate-y-6">
            <h3
                class="text-sm md:text-lg font-semibold text-white transition-transform duration-700 ease-in-out transform group-hover:-translate-y-4">
                {{ $item->title }}
            </h3>
            <h3
                class="text-[10px] md:text-xs text-white transition-transform duration-1000 ease-in-out transform group-hover:-translate-y-4">
                {!! Str::limit($item->content, 50) !!}
            </h3>
        </div>

        <!-- Tombol muncul saat hover -->
        <span
            class="opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 inline-block mt-1">
            <button
                class="px-3 py-1 text-sm bg-teal-700 text-white rounded hover:bg-teal-300 hover:text-teal-900 transition-colors">
                {{ __('button.read') }} →
            </button>
        </span>

    </div>
</a>
