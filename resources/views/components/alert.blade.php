@props([
    'type' => 'success',
    'message' => '',
    'duration' => 3000, // ms
])

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, {{ $duration }})" x-show="show" x-transition
    class="rounded-md p-4 mb-4 text-sm
        {{ $type === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
        {{ $type === 'error' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
    {{ $message }}
</div>
