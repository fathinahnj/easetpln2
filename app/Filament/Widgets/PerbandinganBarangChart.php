<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PerbandinganBarangChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Perbandingan Status Barang per Dua Bulan';
    protected ?string $maxHeight = '300px';

    protected function getFilters(): ?array
    {
        $years = DB::table('barangs')
            ->selectRaw('YEAR(updated_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Jika belum ada data, tampilkan tahun sekarang
        if (empty($years)) {
            $years = [date('Y')];
        }

        return array_combine($years, $years);
    }

    protected function getData(): array
    {
        $year = $this->filter ?? date('Y');

        // Daftar interval dua bulan
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

            $result = DB::table('barangs')
                ->selectRaw("
                    SUM(CASE WHEN status = 'Baik' THEN 1 ELSE 0 END) as Baik,
                    SUM(CASE WHEN status = 'Rusak' THEN 1 ELSE 0 END) as Rusak
                ")
                ->whereYear('updated_at', $year)
                ->whereIn(DB::raw('MONTH(updated_at)'), $months)
                ->first();

            $baikData[] = $result->Baik ?? 0;
            $rusakData[] = $result->Rusak ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Baik',
                    'data' => $baikData,
                    'backgroundColor' => '#2ecc71',  // hijau
                ],
                [
                    'label' => 'Rusak',
                    'data' => $rusakData,
                    'backgroundColor' => '#e74c3c', // merah
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0, // hilangkan angka desimal
                        'stepSize' => 1,  // loncatan antar angka = 1
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
