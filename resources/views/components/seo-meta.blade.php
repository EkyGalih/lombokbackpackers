@if (!empty($meta))
    @if (!empty($meta->meta_description))
        <meta name="description" content="{{ $meta->meta_description }}">
    @endif

    @if (!empty($meta->keywords))
        <meta name="keywords" content="{{ $meta->keywords }}">
    @endif

    @if (!empty($meta->canonical_url))
        <link rel="canonical" href="{{ $meta->canonical_url }}">
    @endif

    @if (!empty($meta->robots))
        <meta name="robots" content="{{ $meta->robots }}">
    @endif

    @if (!empty($meta->og_image))
        <meta property="og:image" content="{{ asset('storage/' . $meta->og_image) }}">
    @endif
@endif
