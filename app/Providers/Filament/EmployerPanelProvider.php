<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Employer;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Pages\Tenancy\RegisterEmployer;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class EmployerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('employer')
            ->path('employer')
            ->login()
            ->registration(Register::class)
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->tenant(Employer::class)
            ->tenantRegistration(RegisterEmployer::class)
            // ->tenantProfile(EditTenantProfile::class)
            ->discoverResources(in: app_path('Filament/Employer/Resources'), for: 'App\\Filament\\Employer\\Resources')
            ->discoverPages(in: app_path('Filament/Employer/Pages'), for: 'App\\Filament\\Employer\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Employer/Widgets'), for: 'App\\Filament\\Employer\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications()
            ->databaseTransactions()
            ->broadcasting(false)
            ->spa()
            ->sidebarCollapsibleOnDesktop();
    }
}
