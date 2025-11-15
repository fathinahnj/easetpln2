<?php

namespace App\Filament\Resources\HistoryLaporans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HistoryLaporanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no')
                    ->numeric(),
                TextInput::make('no_reg'),
                TextInput::make('nama_barang')
                    ->required(),
                TextInput::make('unit'),
                TextInput::make('ruangan'),
                TextInput::make('status'),
                TextInput::make('progress_aksi'),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                DatePicker::make('tanggal_laporan'),
            ]);
    }
}
