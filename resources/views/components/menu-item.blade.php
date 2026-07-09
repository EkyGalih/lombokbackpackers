@props(['item', 'depth' => 0, 'isMobile' => false])

<li class="relative group" x-data="{ open: false }" @click.outside="open = false" 
    @if(!$isMobile)
    @mouseenter="open = true" @mouseleave="open = false"
    @endif
>
    {{-- Item utama --}}
    @if ($item->children->count())
        {{-- Parent: button for toggling --}}
        <button
            @click="open = !open"
            type="button"
            class="flex items-center justify-between w-full gap-1 transition-all duration-300 whitespace-nowrap
            {{ $depth === 0 ? 'py-2 font-medium hover:text-lime-400' : 'px-3 py-1.5 text-sm text-slate-700 hover:bg-teal-50 hover:text-teal-700 rounded-md text-left' }}
            "
        >
            <span>{{ $item->name }}</span>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-3.5 w-3.5 text-current transform transition-transform duration-300 ml-2"
                :class="open ? '{{ $depth === 0 && !$isMobile ? 'rotate-180' : 'rotate-90' }}' : ''" 
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.586l3.71-3.356a.75.75 0 111.02 1.1l-4 3.625a.75.75 0 01-1.02 0l-4-3.625a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    @else
        {{-- Leaf: anchor link --}}
        <a href="{{ config('app.url') . $item->url }}"
            class="flex items-center justify-between w-full gap-1 transition-all duration-300 block whitespace-nowrap
            {{ $depth === 0 ? 'py-2 font-medium hover:text-lime-400' : 'px-3 py-1.5 text-sm text-slate-700 hover:bg-teal-50 hover:text-teal-700 rounded-md text-left' }}
            "
        >
            {{ $item->name }}
        </a>
    @endif

    {{-- Child menu --}}
    @if ($item->children->count())
        <ul x-show="open" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 {{ $isMobile ? '-translate-y-1' : 'translate-y-2' }}"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 {{ $isMobile ? '-translate-y-1' : 'translate-y-2' }}"
            class="
                {{ $isMobile ? 'pl-3 mt-1 border-l border-teal-200 ml-2' : 'absolute z-50 min-w-[200px] w-max p-1 bg-white rounded-xl shadow-lg border border-slate-100 text-slate-800' }}
                {{ !$isMobile && $depth === 0 ? 'left-0 mt-2 origin-top-left' : '' }}
                {{ !$isMobile && $depth > 0 ? 'left-full top-0 ml-1 origin-top-left' : '' }}
            "
            style="display: none;"
        >
            @foreach ($item->children as $child)
                <x-menu-item :item="$child" :depth="$depth + 1" :isMobile="$isMobile" />
            @endforeach
        </ul>
    @endif
</li>
