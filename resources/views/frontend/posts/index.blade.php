@section('title')
    <x-title :title="'BLOG | '"/>
@endsection

<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ __('message.post.title_all') }}" breadcrumb="{!! $breadcrumb ?? __('message.post.title_all') !!}" />
    </x-slot>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6 text-center">
            <div class="grid md:grid-cols-3 gap-8 animate-fade-in">
                <!-- Kolom Konten (Post List) -->
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if ($posts->count())
                            @foreach ($posts as $post)
                                <div
                                    class="group bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                                    <img src="{{ $post->media?->first()?->url ?? asset('defaults/no-image.jpg') }}"
                                        alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-md" />

                                    <div class="p-6 text-left">
                                        <p class="text-gray-500 text-sm mb-1">
                                            {{ \Carbon\Carbon::parse($post->created_at)->locale(app()->getLocale())->translatedFormat('d F Y') }}
                                            / by {{ $post->author->name }}
                                        </p>

                                        <h2 class="text-2xl font-bold text-gray-900 hover:text-teal-700 transition">
                                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h2>

                                        <p class="mt-2 text-gray-700 text-sm line-clamp-3">
                                            {!! Str::limit(strip_tags($post->content), 150) !!}
                                        </p>

                                        <a href="{{ route('blog.show', $post->slug) }}"
                                            class="inline-block mt-4 text-teal-600 hover:underline text-sm font-semibold">
                                            {{ __('button.read') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 animate-fade-in">{{ __('message.post.message') . $breadcrumb }}</p>
                        @endif
                    </div>

                    {{-- Optional Pagination --}}
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6 text-left">
                    {{-- Seearch --}}
                    <div
                        class="bg-blue-100 p-4 rounded-lg animate-slide-in-up transition-all duration-700 hover:scale-[1.02]">
                        <h2 class="font-bold text-left mb-4 text-3xl text-slate-900 animate-fade-in delay-100">
                            {{ __('message.post.search') }}
                        </h2>
                        <form method="GET" class="flex items-center space-x-2">
                            {{-- Hidden inputs to keep category and tag filters --}}
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif

                            @if (request('tag'))
                                <input type="hidden" name="tag" value="{{ request('tag') }}">
                            @endif

                            <input type="text" name="search"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-400 transition"
                                placeholder="Search ..." value="{{ request('search') }}">
                            <button type="submit"
                                class="bg-lime-600 text-white px-4 py-2 rounded-lg hover:bg-lime-700 transition-all duration-300">
                                {{ __('message.post.search') }}
                            </button>
                        </form>
                    </div>


                    <!-- Categories -->
                    <div class="bg-sky-100 p-4 rounded-lg">
                        <h2 class="font-bold text-2xl mb-4 text-slate-900">{{ __('message.post.categories') }}</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($categories as $category)
                                <a href="{{ route('blog.index', ['category' => $category]) }}"
                                    class="bg-lime-500 text-white text-sm px-4 py-1 rounded-full hover:bg-teal-900 hover:text-teal-500- transition-all duration-300">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="bg-sky-100 p-4 rounded-lg">
                        <h2 class="font-bold text-2xl mb-4 text-slate-900">{{ __('message.post.tags') }}</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($allTags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                                    class="bg-teal-900 text-white text-sm px-4 py-1 rounded-full hover:bg-lime-400 hover:text-slate-900 transition-all duration-300">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
