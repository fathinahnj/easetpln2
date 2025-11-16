<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PerbandinganBarangChart extends ChartWidget
{
    protected ?string $heading = 'Total Laporan Barang yang Rusak/Perlu Diperbaiki';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Contoh agregasi data berdasarkan bulan (sesuaikan dengan struktur tabelmu)
        $data = DB::table('history_laporans')
            ->selectRaw("
                CONCAT(MONTHNAME(tanggal_laporan), ' ', YEAR(tanggal_laporan)) as periode,
                SUM(CASE WHEN status = 'Baik' THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN status = 'Rusak' THEN 1 ELSE 0 END) as rusak
            ")
            ->groupBy('periode')
            ->orderByRaw('MIN(tanggal_laporan)')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Baik',
                    'data' => $data->pluck('baik'),
                    'backgroundColor' => '#5B8FF9', // biru
                ],
                [
                    'label' => 'Rusak',
                    'data' => $data->pluck('rusak'),
                    'backgroundColor' => '#5AD8A6', // hijau
                ],
            ],
            'labels' => $data->pluck('periode'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
