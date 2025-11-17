<?php

namespace App\Filament\Resources\HistoryLaporans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\DateTimeEntry;
use Filament\Schemas\Schema;

class HistoryLaporanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_barang')
                    ->label('Nama Barang'),

                TextEntry::make('status')
                    ->label('Status'),

                TextEntry::make('progress_aksi')
                    ->label('Progress Aksi'), // biar teks panjang bisa lebar penuh

                TextEntry::make('tanggal_laporan')
                    ->label('Tanggal Laporan'),
            ]);
    }
}
