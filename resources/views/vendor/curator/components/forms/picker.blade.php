@php
    $statePath = $getStatePath();
    $items = $getState() ?? [];
    $itemsCount = count($items);
    $isMultiple = $isMultiple();
    $maxItems = $getMaxItems();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        insertMedia(event) {
            if (event.detail.statePath !== '{{ $statePath }}') return;
            $wire.$set(event.detail.statePath, event.detail.media);
        },
    }" x-on:insert-content.window="insertMedia" style="width: 100%;">
        <ul x-sortable
            wire:end.stop="mountFormComponentAction('{{ $statePath }}', 'reorder', { items: $event.target.sortable.toArray() })"
            style="
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 16px;
                width: 100%;
                list-style: none;
                padding: 0;
                margin: 0;
            ">
            @foreach ($items as $uuid => $item)
                <li wire:key="{{ $this->getId() }}.{{ $uuid }}.{{ $field::class }}.item"
                    x-sortable-item="{{ $uuid }}"
                    style="
                        position: relative;
                        border: 1px solid #ccc;
                        border-radius: 6px;
                        overflow: hidden;
                        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
                        aspect-ratio: 1/1;
                        background: #f9f9f9;
                    ">
                    {{-- Drag handle --}}
                    @if ($isMultiple)
                        <div x-sortable-handle
                            style="
                                position: absolute;
                                top: 4px;
                                left: 4px;
                                z-index: 40;
                                padding: 2px;
                                cursor: move;
                                background: rgba(0,0,0,0.5);
                                border-radius: 4px;
                            ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2v20M12 2l-3 3m3-3l3 3M12 22l-3-3m3 3l3-3M2 12h20M2 12l3-3m-3 3l3 3M22 12l-3-3m3 3l-3 3" />
                            </svg>
                        </div>
                    @endif

                    {{-- Action buttons --}}
                    <div
                        style="
                            position: absolute;
                            top: 4px;
                            right: 4px;
                            z-index: 50;
                            background: rgba(0,0,0,0.5);
                            border-radius: 4px;
                            padding: 2px;
                        ">
                        <x-filament-actions::group :actions="[
                            $getAction('view')(['url' => $item['url']]),
                            $getAction('edit')(['id' => $item['id']]),
                            $getAction('download')(['uuid' => $uuid]),
                            $getAction('remove')(['uuid' => $uuid]),
                        ]" color="white" size="xs"
                            dropdown-placement="bottom-end" />
                    </div>

                    {{-- Media --}}
                    @if (str($item['type'])->contains('image'))
                        <img src="{{ $item['large_url'] }}" alt="{{ $item['alt'] ?? $item['name'] }}"
                            @if ($shouldLazyLoad()) loading="lazy" @endif
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @elseif (str($item['type'])->contains('video'))
                        <video controls src="{{ $item['url'] }}"
                            @if ($shouldLazyLoad()) preload="none" @endif
                            style="width: 100%; height: 100%; object-fit: cover;"></video>
                    @else
                        <x-curator::document-image label="{{ $item['name'] }}" icon-size="xl"
                            type="{{ $item['type'] }}" extension="{{ $item['ext'] }}" />
                    @endif

                    {{-- Caption --}}
                    <div
                        style="
                            position: absolute;
                            bottom: 0;
                            left: 0;
                            right: 0;
                            font-size: 11px;
                            color: white;
                            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
                            padding: 6px;
                            display: flex;
                            justify-content: space-between;
                            gap: 6px;
                        ">
                        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $item['pretty_name'] }}
                        </span>
                        <span style="flex-shrink: 0;">{{ $item['size_for_humans'] }}</span>
                    </div>
                </li>
            @endforeach
        </ul>

        <div style="margin-top: 16px; display: flex; gap: 8px; align-items: center;">
            @if ($itemsCount === 0 || $isMultiple)
                @if (!$maxItems || $itemsCount < $maxItems)
                    {{ $getAction('open_curator_picker') }}
                @endif
            @endif

            @if ($itemsCount > 1)
                {{ $getAction('removeAll') }}
            @endif
        </div>
    </div>
</x-dynamic-component>
