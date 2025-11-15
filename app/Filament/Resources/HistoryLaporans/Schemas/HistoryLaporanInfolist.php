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
                TextEntry::make('no')
                    ->numeric(),
                TextEntry::make('no_reg'),
                TextEntry::make('nama_barang'),
                TextEntry::make('unit'),
                TextEntry::make('ruangan'),
                TextEntry::make('status'),
                TextEntry::make('progress_aksi'),
                TextEntry::make('tanggal_laporan')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
