<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use App\Models\Ruangan;
use App\Models\Barang;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('no')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(fn() => Barang::max('no') + 1),

                TextInput::make('no_reg')
                    ->required()
                    ->numeric(),

                TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                // Select::make('unit')
                //     ->label('Unit')
                //     ->options(Ruangan::pluck('unit', 'unit')->unique())
                //     ->reactive()
                //     ->afterStateUpdated(fn(callable $set) => $set('ruangan_id', null))
                //     ->required(),

                Select::make('unit')
                    ->label('Unit')
                    ->options(Ruangan::pluck('unit', 'unit')->unique())
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('ruangan_id', null))
                    ->dehydrated(false) // ← penting: jangan simpan ke database
                    ->required(),

                Select::make('ruangan_id')
                    ->label('Ruangan')
                    ->options(function (callable $get) {
                        $unit = $get('unit');
                        if (!$unit) {
                            return [];
                        }
                        return Ruangan::where('unit', $unit)
                            ->pluck('ruangan', 'id');
                    })
                    ->reactive()
                    ->required()
                    ->searchable(),

                Select::make('status')
                    ->options([
                        'Baik' => 'Baik',
                        'Perlu Diperbaiki' => 'Perlu Diperbaiki',
                        'Rusak' => 'Rusak',
                    ])
                    ->default('Baik')
                    ->reactive(),

                Select::make('progress_aksi')
                    ->label('Progress Aksi')
                    ->options(function (callable $get) {
                        $status = $get('status');
                        return match ($status) {
                            'Baik' => ['Tidak Ada' => 'Tidak Ada'],
                            'Rusak' => ['Perlu Diganti' => 'Perlu Diganti', 'Dibuang' => 'Dibuang'],
                            'Perlu Diperbaiki' => ['Belum Ditindak' => 'Belum Ditindak', 'Sementara Diperbaiki' => 'Sementara Diperbaiki'],
                        };
                    })
                    ->required()
                    ->default('Tidak Ada'),

                TextInput::make('deskripsi')
                    ->maxLength(65535),

                Select::make('urgensi')
                    ->options([
                        'Rendah' => 'Rendah',
                        'Sedang' => 'Sedang',
                        'Tinggi' => 'Tinggi',
                    ])
                    ->required()
                    ->default('Rendah'),
            ]);
    }
}
