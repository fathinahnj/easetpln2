<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no')
                    ->required()
                    ->numeric(),
                TextInput::make('no_reg')
                    ->required()
                    ->numeric(),
                TextInput::make('nama_barang')
                    ->required(),
                TextInput::make('unit')
                    ->required()
                    ->numeric(),
                TextInput::make('ruangan')
                    ->required()
                    ->numeric(),

                Select::make('status')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak' => 'Rusak',
                        'Perlu Diperbaiki' => 'Perlu Diperbaiki',
                    ])
                    ->default('Baik')
                    ->reactive(),

                Select::make('progress_aksi')
                    ->options(function (callable $get) {
                        $status = $get('status');
                        return match ($status) {
                            'Baik' => [
                                'Tidak Ada' => 'Tidak Ada',
                            ],
                            'Rusak' => [
                                'Perlu Diganti' => 'Perlu Diganti',
                                'Dibuang' => 'Dibuang',
                            ],
                            'Perlu Diperbaiki' => [
                                'Belum Ditindak' => 'Belum Ditindak',
                                'Sementara Diperbaiki' => 'Sementara Diperbaiki',
                            ],
                            default => [],
                        };
                    })
                    ->required()
                    ->default('Tidak Ada'),

                TextInput::make('deskripsi'),
                Select::make('urgensi')
                    ->options(['Tinggi' => 'Tinggi', 'Sedang' => 'Sedang', 'Rendah' => 'Rendah'])
                    ->default('Rendah')
                    ->required(),
            ]);
    }
}
