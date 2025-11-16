<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\Barang;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $totalBarang = Barang::whereHas('ruangan', function ($query) use ($user) {
            $query->where('unit', $user->unit);
        })->count();

        return [
            Stat::make('Total User', User::count())
                ->description('Jumlah seluruh user yang terdaftar'),

            Stat::make('Total Unit', Ruangan::count())
                ->description('Jumlah total kantor/unit'),

            Stat::make('Total Barang', $totalBarang)
                ->description('Jumlah barang tercatat'),
        ];
    }
}
