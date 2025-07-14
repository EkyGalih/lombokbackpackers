<x-filament-widgets::widget wire:poll.5s="updateStatus">
    <x-filament::section>
        <h3 class="text-md font-bold mb-2">⚙️ System Status</h3>

        <div class="grid grid-cols-1 gap-2 text-sm">
            <div>
                <span class="font-semibold">Server Uptime:</span>
                {{ $uptime }}
            </div>

            <div>
                <span class="font-semibold">Memory Usage:</span>
                {{ $memoryUsage }}
            </div>

            <div>
                <span class="font-semibold">Storage Usage:</span>
                {{ $storageUsage }}
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
