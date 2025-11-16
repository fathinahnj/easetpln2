<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Ruangan;
use Filament\Forms\Components\Select;
use Filament\Widgets\PieChartWidget;

class BarangStatusChart extends PieChartWidget
{
    protected ?string $heading = 'Grafik Status Barang Saat Ini';
    protected ?string $maxHeight = '250px';   // tinggi chart

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

        // $data = Barang::query()
        //     ->selectRaw('status, COUNT(*) as total')
        //     ->groupBy('status')
        //     ->pluck('total', 'status');   // ['Baik' => 10, 'Rusak' => 3, ...]

        // return [
        //     'labels' => $data->keys()->toArray(),   // ['Baik', 'Rusak', ...]
        //     'datasets' => [
        //         [
        //             'label' => 'Jumlah Barang',
        //             'data'  => $data->values()->toArray(), // [10, 3, ...]
        //         ],
        //     ],
        // ];
        $filters = $this->filterFormData ?? [];

        $query = Barang::query();

        if (!empty($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }

        if (!empty($filters['ruangan_id'])) {
            $query->where('ruangan_id', $filters['ruangan_id']);
        }

        $baik = (clone $query)->where('status', 'Baik')->count();
        $rusak = (clone $query)->where('status', 'Rusak')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Status Barang',
                    'data' => [$baik, $rusak],
                    'backgroundColor' => ['#2ecc71', '#e74c3c'],
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
