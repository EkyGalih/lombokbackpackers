<div
    style="
        position: relative;
        border-radius: 0.75rem 0.75rem 0 0;
        overflow: hidden;
        width: 100%;
        aspect-ratio: 16/9;
    "
>
    @php
        $record = $getRecord();
    @endphp

    <div
        style="
            border-radius: 0.75rem 0.75rem 0 0;
            height: 150px;
            overflow: hidden;
            background-color: #f3f4f6;
        "
    >
        @if (str($record->type)->contains('image'))
            <img
                src="{{ $record->getSignedUrl(['w' => 640, 'h' => 320, 'fit' => 'crop', 'fm' => 'webp']) }}"
                alt="{{ $record->alt }}"
                style="
                    height: 150px;
                    width: 100%;
                    object-fit: cover;
                "
            />
        @else
            <x-curator::document-image
                :label="$record->name"
                icon-size="lg"
                :type="$record->type"
                :extension="$record->ext"
            />
        @endif

        <div
            style="
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 4px 6px;
                font-size: 12px;
                color: #fff;
                background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
                gap: 6px;
            "
        >
            <p
                style="
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    max-width: 70%;
                "
            >
                {{ $record->pretty_name }}
            </p>
            <p style="flex-shrink: 0;">{{ $record->size_for_humans }}</p>
        </div>
    </div>
</div>
