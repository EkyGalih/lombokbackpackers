<x-filament-widgets::widget wire:poll.5s="updateStatus">
    <x-filament::section>
        <h3 class="text-md font-bold mb-2">⚙️ System Status</h3>

        <div class="grid grid-cols-1 gap-2 text-sm">
            <div>
                <span class="font-semibold">Server Uptime:</span>
                <span style="color: rgb(194, 194, 194); font-weight: bold">{{ $uptime }}</span>
            </div>

            <div>
                <span class="font-semibol">Memory Usage:</span>
                <span style="color: rgb(0, 85, 0); font-weight: bold">{{ $memoryUsage }}</span>
            </div>

            <div>
                <span class="font-semibold text-orange-400">Storage Usage:</span>
                <span style="color: rgb(145, 95, 2); font-weight: bold">{{ $storageUsage }}</span>
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
