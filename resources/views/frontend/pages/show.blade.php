@section('title')
    <x-title :title="$page->title . ' | '"/>
@endsection

@section('seoMeta')
    <x-seo-meta :meta="$meta" />
@endsection

<x-guest-layout>
    <x-slot name="nav">
        <x-header title="{{ $page->title }}" breadcrumb="" />
    </x-slot>

    <section class="bg-gray-100 py-16">
        <div class="container max-w-screen-xl mx-auto px-6 text-left">
            @if ($page)

                <div class="grid md:grid-cols-3 gap-8 animate-fade-in">
                    <!-- Kolom Konten -->
                    <div class="md:col-span-2 space-y-6">
                        <div class="group relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl">
                            <div class="overflow-hidden">
                                @if ($page->media?->first()?->url != null)
                                    <img src="{{ $page->media?->first()?->url ?? asset('defaults/no-image.jpg') }}"
                                        alt="{{ $page->title }}" class="w-full h-[600px] object-cover">
                                @endif
                            </div>
                        </div>

                        <div class="prose prose-sm max-w-none text-slate-900 animate-fade-in">
                            <h1>{{ $page->title }}</h1>
                            <hr />
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 animate-fade-in">Belum ada page tersedia.</p>
            @endif
        </div>
    </section>

</x-guest-layout>
