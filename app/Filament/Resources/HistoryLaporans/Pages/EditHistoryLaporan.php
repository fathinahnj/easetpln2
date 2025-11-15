<?php

namespace App\Filament\Resources\HistoryLaporans\Pages;

use App\Filament\Resources\HistoryLaporans\HistoryLaporanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHistoryLaporan extends EditRecord
{
    protected static string $resource = HistoryLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
