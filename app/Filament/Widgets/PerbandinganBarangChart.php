<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PerbandinganBarangChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Perbandingan Status Barang per Dua Bulan';
    protected ?string $maxHeight = '300px';

    // 🔹 Filter Tahun di atas chart
    protected function getFilters(): ?array
    {
        $years = DB::table('barangs')
            ->selectRaw('YEAR(updated_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($years)) {
            $years = [date('Y')];
        }

        return array_combine($years, $years);
    }

    // 🔹 Data utama chart
    protected function getData(): array
    {
        $user = Auth::user();
        $year = $this->filter ?? date('Y');

        // Interval dua bulan
        $intervals = [
            'Jan–Feb' => [1, 2],
            'Mar–Apr' => [3, 4],
            'Mei–Jun' => [5, 6],
            'Jul–Agus' => [7, 8],
            'Sep–Okt' => [9, 10],
            'Nov–Des' => [11, 12],
        ];

        $labels = [];
        $baikData = [];
        $rusakData = [];

        foreach ($intervals as $label => $months) {
            $labels[] = $label;

            // Query utama
            $query = DB::table('barangs')
                ->join('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
                ->selectRaw("
                    SUM(CASE WHEN LOWER(barangs.status) = 'baik' THEN 1 ELSE 0 END) as Baik,
                    SUM(CASE WHEN LOWER(barangs.status) = 'rusak' THEN 1 ELSE 0 END) as Rusak
                ")
                ->whereYear('barangs.updated_at', $year)
                ->whereIn(DB::raw('MONTH(barangs.updated_at)'), $months);

            // 🔸 Filter otomatis untuk Admin Unit
            if ($user->role !== 'Admin Utama') {
                $query->where('ruangans.unit', $user->unit);
            }

            $result = $query->first();

            $baikData[] = $result->Baik ?? 0;
            $rusakData[] = $result->Rusak ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Baik',
                    'data' => $baikData,
                    'backgroundColor' => '#34D399', // hijau
                ],
                [
                    'label' => 'Rusak',
                    'data' => $rusakData,
                    'backgroundColor' => '#F87171', // merah
                ],
            ],
            'labels' => $labels,
        ];
    }

    // 🔹 Opsi chart (hilangkan desimal di Y-axis)
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
