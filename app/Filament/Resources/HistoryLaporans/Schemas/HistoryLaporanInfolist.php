<?php

namespace App\Filament\Resources\HistoryLaporans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HistoryLaporanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('status')
                    ->label('Status'),

                TextEntry::make('progress_aksi')
                    ->label('Progress Aksi')
                    ->columnSpanFull(), // biar teks panjang bisa lebar penuh

            ]);
    }
}
