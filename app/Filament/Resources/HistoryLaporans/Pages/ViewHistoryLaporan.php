<?php

namespace App\Filament\Resources\HistoryLaporans\Pages;

use App\Filament\Resources\HistoryLaporans\HistoryLaporanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHistoryLaporan extends ViewRecord
{
    protected static string $resource = HistoryLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
