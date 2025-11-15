<?php

namespace App\Filament\Resources\HistoryLaporans\Pages;

use App\Filament\Resources\HistoryLaporans\HistoryLaporanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHistoryLaporans extends ListRecords
{
    protected static string $resource = HistoryLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return []; // sembunyikan tombol "Create"
    }

    protected function getTableActions(): array
    {
        return []; // menonaktifkan tombol Edit/Delete di setiap row
    }
}
