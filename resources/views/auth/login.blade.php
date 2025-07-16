<x-filament-panels::page.simple>
    <x-slot name="heading">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 text-2xl font-bold text-amber-600">
                <x-heroicon-o-lock-closed class="w-6 h-6" />
                {{ __('Sign In') }}
            </span>
            <p class="text-sm text-gray-600 mt-1">
                Welcome back! Please sign in to continue.
            </p>
        </div>
    </x-slot>

    {{ \Filament\Support\Facades\FilamentView::renderHook(
        'panels::auth.login.form.before',
        scopes: $this->getRenderHookScopes(),
    ) }}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(
        'panels::auth.login.form.after',
        scopes: $this->getRenderHookScopes(),
    ) }}
</x-filament-panels::page.simple>
