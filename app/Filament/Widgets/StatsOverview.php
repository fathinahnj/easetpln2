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
        $stats = [];

        if ($user->role === 'Admin Utama') {
            $stats[] = Stat::make('Total User', User::count())
                ->description('Jumlah seluruh user yang terdaftar');

            $stats[] = Stat::make(
                'Total Unit',
                Ruangan::select('unit')->distinct()->count('unit')
            )
                ->description('Jumlah total kantor/unit');
        }

        $totalBarang = Barang::when(
            $user->role !== 'Admin Utama',
            fn($query) => $query->whereHas('ruangan', fn($q) => $q->where('unit', $user->unit))
        )->count();

        $stats[] = Stat::make('Total Barang', $totalBarang)
            ->description('Jumlah barang tercatat');

        return $stats;
    }
}
