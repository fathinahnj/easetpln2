<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Barang;
use App\Observers\BarangObserver;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Barang::observe(BarangObserver::class);

        Filament::registerRenderHook(
            'panels::topbar.end',
            fn(): string => view('components.hubungi-admin')->render(),
        );
    }
}
