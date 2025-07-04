<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        app()->setLocale('uz-latn');

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Yellow,
                'danger' => Color::Red,
            ])
            ->discoverResources(
                in: base_path('filament/Resources'),
                for: 'Filament\\Resources'
            )
            ->discoverPages(
                in: base_path('filament/Pages'),
                for: 'Filament\\Pages'
            )
            ->pages([Pages\Dashboard::class])
            ->discoverWidgets(
                in: base_path('filament/Widgets'),
                for: 'Filament\\Widgets'
            )
            ->widgets([Widgets\AccountWidget::class])
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
            ])
            ->authMiddleware([Authenticate::class])
            ->plugins([
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['uz-latn', 'uz-cyrl', 'ru'])
                    ->getLocaleLabelUsing(function ($locale) {
                        return match ($locale) {
                            'uz-latn' => "O'zbek (lotin)",
                            'uz-cyrl' => "O'zbek (kirill)",
                            'ru' => 'Русский',
                        };
                    }),
            ])
            ->navigationGroups([
                'Mahsulotlar', 'Ijtimoiy tarmoqlar', 'Ommaviy',
            ])
            ->brandName('Sindicat');
    }
}
