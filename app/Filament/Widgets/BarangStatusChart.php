<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Ruangan;
use Filament\Forms\Components\Select;
use Filament\Widgets\PieChartWidget;
use Illuminate\Support\Facades\DB;

class BarangStatusChart extends PieChartWidget
{
    protected ?string $heading = 'Grafik Status Barang Saat Ini';
    protected ?string $maxHeight = '265px';   // tinggi chart

    // 🔹 1. Tambahkan filter unit dari tabel ruangans
    protected function getFilters(): ?array
    {
        $units = DB::table('ruangans')
            ->select('unit')
            ->distinct()
            ->orderBy('unit')
            ->pluck('unit')
            ->toArray();

        $filters = ['all' => 'Semua Unit'];
        foreach ($units as $unit) {
            $filters[$unit] = $unit;
        }

        return $filters;
    }

    // Untuk menampilkan filter Unit & Ruangan di atas chart
    protected function getFormSchema(): array
    {
        return [
            Select::make('unit_id')
                ->label('Unit')
                ->options(Ruangan::all()->pluck('unit', 'id'))
                ->reactive()
                ->afterStateUpdated(fn(callable $set) => $set('ruangan_id', null)),

            Select::make('ruangan_id')
                ->label('Ruangan')
                ->options(function (callable $get) {
                    $unitId = $get('unit_id');
                    if (!$unitId) return [];
                    return Ruangan::where('unit_id', $unitId)->pluck('nama', 'id');
                })
                ->reactive(),
        ];
    }

    // Data chart berdasarkan filter di atas
    protected function getData(): array
    {
        $filterUnit = $this->filter ?? 'all';

        $query = DB::table('barangs')
            ->join('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->selectRaw("
                SUM(CASE WHEN LOWER(barangs.status) = 'baik' THEN 1 ELSE 0 END) as baik,
                SUM(CASE WHEN LOWER(barangs.status) = 'rusak' THEN 1 ELSE 0 END) as rusak
            ");

        if ($filterUnit !== 'all') {
            $query->where('ruangans.unit', $filterUnit);
        }

        $data = $query->first();

        return [
            'datasets' => [
                [
                    'data' => [
                        $data->baik ?? 0,
                        $data->rusak ?? 0,
                    ],
                    'backgroundColor' => ['#5AD8A6', '#F4664A'],
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
