<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\Barang;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::count())
                ->description('Jumlah seluruh user yang terdaftar'),

            Stat::make('Total Unit', Ruangan::count())
                ->description('Jumlah total kantor/unit'),

            Stat::make('Total Barang', Barang::count())
                ->description('Jumlah barang tercatat'),
        ];
    }
}
