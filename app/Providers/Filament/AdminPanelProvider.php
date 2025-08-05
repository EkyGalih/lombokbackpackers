<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use App\Filament\Resources\ActivitiesWidgetResource\Widgets\ActivitiesWidget;
use App\Filament\Resources\BookingPaymentChartResource\Widgets\BookingPaymentChart as WidgetsBookingPaymentChart;
use App\Filament\Resources\CustomAccountWidgetResource\Widgets\CustomAccountWidget;
use App\Filament\Resources\DailyTrendChartResource\Widgets\DailyTrendChart;
use App\Filament\Resources\StatsWidgetResource\Widgets\StatsWidget;
use App\Filament\Resources\SystemStatusWidgetResource\Widgets\SystemStatusWidget;
use App\Filament\Resources\TourCompositionChartResource\Widgets\TourCompositionChart;
use App\Filament\Widgets\BookingPaymentChart;
use Awcodes\Curator\CuratorPlugin;
use Biostate\FilamentMenuBuilder\Filament\Resources\MenuItemResource;
use Biostate\FilamentMenuBuilder\Filament\Resources\MenuResource;
use Hasnayeen\Themes\ThemesPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\UserMenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\View;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Pboivin\FilamentPeek\FilamentPeekPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->profile(\App\Filament\Resources\EditProfileResource\Pages\EditProfile::class)
            ->spa()
            ->favicon(asset('storage/' . ltrim(app(\App\Settings\WebsiteSettings::class)->site_logo, '/')))
            ->breadcrumbs(false)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->userMenuItems([
                UserMenuItem::make()
                    ->label('🌐: ' . strtoupper(app()->getLocale()))
                    ->icon('heroicon-o-language')
                    ->url(fn() => route('admin-lang.switch', [
                        'locale' => app()->getLocale() === 'id' ? 'en' : 'id',
                    ])),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                'Catalog',
                'Menu',
                'Transactions',
                'Settings'
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                CustomAccountWidget::class,
                SystemStatusWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetTheme::class,
            ])
            ->authGuard('web')
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                ThemesPlugin::make(),
                CuratorPlugin::make()
                    ->label('Media Library')
                    ->pluralLabel('Media Library')
                    ->navigationIcon('heroicon-o-camera')
                    ->navigationGroup('Menu')
                    ->navigationSort(6),
                \Biostate\FilamentMenuBuilder\FilamentMenuBuilderPlugin::make(),
                FilamentPeekPlugin::make()
                    ->disablePluginStyles(),
                \BezhanSalleh\FilamentGoogleAnalytics\FilamentGoogleAnalyticsPlugin::make()
            ]);
    }

    public function boot(): void
    {
        View::composer('filament::layouts.app.topbar.end', function ($view) {
            $view->with('localeSwitcher', view('components.locale-switcher'));
        });

        \Filament\Facades\Filament::serving(function () {
            MenuResource::navigationGroup('Settings');
            MenuItemResource::canViewAny(fn() => false);
        });
    }
}
