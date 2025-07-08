@props(['item', 'depth' => 0])

<li class="pl-{{ $depth * 4 }}">
    <a href="{{ $item->url }}" class="block px-2 py-1 hover:underline"
        :class="scrolled ? 'text-slate-900' : 'text-white'">
        {{ $item->name }}
    </a>

    @if ($item->childrenRecursive->count())
        <ul class="space-y-1 mt-1">
            @foreach ($item->childrenRecursive as $child)
                <x-menu-item :item="$child" :depth="$depth + 1" />
            @endforeach
        </ul>
    @endif
</li>
