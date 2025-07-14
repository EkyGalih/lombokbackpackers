<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center space-x-4">
            <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                alt="Avatar" class="w-12 h-12 rounded-full">

            <div>
                <div class="font-semibold">{{ $user->name }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ strtoupper($user->role) }}</div>
                <div class="text-xs text-gray-400 mt-1">Last login: {{ $user->last_login_at ?? '-' }}</div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
