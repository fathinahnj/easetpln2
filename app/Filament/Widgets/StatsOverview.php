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

        // 🔹 Jika Admin Utama → tampilkan semua
        if ($user->role === 'Admin Utama') {
            $stats[] = Stat::make('Total User', User::count())
                ->description('Jumlah seluruh user yang terdaftar')
                ->color('primary');

            $stats[] = Stat::make(
                'Total Unit',
                Ruangan::select('unit')->distinct()->count('unit')
            )
                ->description('Jumlah total kantor/unit')
                ->color('success');
        }

        // 🔹 Total Barang — selalu ditampilkan untuk semua role
        $totalBarang = Barang::when(
            $user->role !== 'Admin Utama',
            fn($query) => $query->whereHas('ruangan', fn($q) => $q->where('unit', $user->unit))
        )->count();

        $stats[] = Stat::make('Total Barang', $totalBarang)
            ->description('Jumlah barang tercatat');

        return $stats;
    }
}
