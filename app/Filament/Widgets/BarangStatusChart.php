<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class BarangStatusChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Status Barang Saat Ini';
    protected ?string $maxHeight = '265px';

    protected function getData(): array
    {
        $user = Auth::user();

        // Base query: join ke tabel ruangans
        $query = DB::table('barangs')
            ->join('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->selectRaw("
                SUM(CASE WHEN LOWER(barangs.status) = 'baik' THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN LOWER(barangs.status) = 'rusak' THEN 1 ELSE 0 END) as rusak
            ");

        // 🔹 Filter otomatis berdasarkan role
        if ($user->role !== 'Admin Utama') {
            $query->where('ruangans.unit', $user->unit);
        }

        $data = $query->first();

        return [
            'datasets' => [
                [
                    'label' => 'Status Barang',
                    'data' => [
                        $data->baik ?? 0,
                        $data->rusak ?? 0,
                    ],
                    'backgroundColor' => ['#34D399', '#F87171'],
                ],
            ],
            'labels' => ['Baik', 'Rusak'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
