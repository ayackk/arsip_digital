<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            ->brandName(new \Illuminate\Support\HtmlString('
                <div style="display:inline-flex; align-items:center; gap:10px; white-space:nowrap;">
                    <img src="'.asset('img/logo.png').'" alt="Logo" style="height:2.4rem; width:auto; flex-shrink:0; max-width:none;">

                    <span style="
                        font-weight:800;
                        font-size:1.6rem;
                        letter-spacing:1.5px;
                        color:#ffab200;
                    ">
                        NADA
                    </span>
                </div>
            '))

            ->brandLogo(null)

            ->colors([
                'primary' => '#ffab96',
                'danger' => Color::Rose,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])

            ->font('Poppins')
            ->favicon(asset('img/favicon.png'))
            ->renderHook(
                'panels::head.end',
                fn () => '<link rel="stylesheet" href="' . asset('css/theme.css') . '">'
            )

            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')

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

            ->authMiddleware([
                Authenticate::class
            ])
            ->globalSearch(false); // Search kanan atas langsung ilang
    }
}
