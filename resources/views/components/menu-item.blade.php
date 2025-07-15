@props(['item', 'depth' => 0, 'isMobile' => false])

<li class="relative" x-data="{ open: false }" @click.outside="open = false">
    {{-- Item utama --}}
    <div>
        <button @click="open = !open" type="button"
            class="flex items-center justify-between w-full px-2 py-1 hover:underline gap-1">
            <a href="{{ config('app.url') . $item->url }}">{{ $item->name }}</a>

            @if ($item->children->count())
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-3.5 w-3.5 text-current transform transition-transform translate-y-0.5"
                    :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.586l3.71-3.356a.75.75 0 111.02 1.1l-4 3.625a.75.75 0 01-1.02 0l-4-3.625a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
            @endif
        </button>
    </div>

    {{-- Child menu --}}
    @if ($item->children->count())
        <ul x-show="open" x-transition
            class="
                md:absolute md:left-0 md:mt-1 md:bg-gradient-to-tr md:from-white md:to-slate-100 md:text-slate-900 md:p-2 md:rounded md:shadow md:z-50 md:min-w-max
                md:space-y-0
                space-y-1 md:space-x-0
                mt-1
            "
            :class="open ? 'block' : 'hidden'">
            @foreach ($item->children as $child)
                <x-menu-item :item="$child" :depth="$depth + 1" />
            @endforeach
        </ul>
    @endif
</li>
