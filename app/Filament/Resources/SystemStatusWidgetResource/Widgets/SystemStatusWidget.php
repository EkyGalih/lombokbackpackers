<?php

namespace App\Filament\Resources\SystemStatusWidgetResource\Widgets;

use Filament\Widgets\Widget;

class SystemStatusWidget extends Widget
{
    protected static string $view = 'filament.resources.system-status-widget-resource.widgets.system-status-widget';

    public static function getColumns(): int
    {
        return 6;
    }

    public $uptime;
    public $memoryUsage;
    public $storageUsage;

    public function mount()
    {
        $this->updateStatus();
    }

    public function updateStatus()
    {
        if (str_starts_with(PHP_OS, 'WIN')) {
            $this->uptime = 'N/A on Windows';
        } else {
            $this->uptime = trim(shell_exec('uptime -p')) ?: 'Unavailable';
        }

        $this->memoryUsage = $this->getServerMemoryUsage();
        $this->storageUsage = $this->getStorageUsage();
    }

    private function getServerMemoryUsage(): string
    {
        $output = shell_exec("free -m | awk 'NR==2{printf \"%s/%s MB (%.2f%%)\", $3,$2,$3*100/$2 }'");
        return $output ?: 'Unavailable';
    }

    private function getStorageUsage(): string
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total - $free;

        $totalGB = $total / 1024 / 1024 / 1024;
        $usedGB = $used / 1024 / 1024 / 1024;
        $freeGB = $free / 1024 / 1024 / 1024;

        $percentUsed = ($used / $total) * 100;

        return sprintf(
            '%.2f GB / %.2f GB (%.1f%% used)',
            $usedGB,
            $totalGB,
            $percentUsed
        );
    }
}
