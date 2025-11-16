<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\BarangStatusChart;
use App\Filament\Widgets\PerbandinganBarangChart;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            BarangStatusChart::class,
            PerbandinganBarangChart::class,
        ];
    }
}
