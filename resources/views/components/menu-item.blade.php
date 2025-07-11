@props(['item', 'depth' => 0])

<li class="relative" x-data="{ open: false }" @click.outside="open = false">
    <div>
        <button @click="open = !open" type="button"
            class="flex items-center justify-between w-full px-2 py-1 hover:underline gap-1"
            :class="scrolled ? 'text-slate-900' : 'text-white'">
            <span>{{ $item->name }}</span>

            @if ($item->childrenRecursive->count())
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

    @if ($item->childrenRecursive->count())
        <ul x-show="open" x-transition class="absolute left-0 mt-1 bg-gradient-to-tr from-white to-slate-300 text-slate-900 p-2 rounded shadow z-50 min-w-max"
            style="display: none;">
            @foreach ($item->childrenRecursive as $child)
                <x-menu-item :item="$child" :depth="$depth + 1" />
            @endforeach
        </ul>
    @endif
</li>
