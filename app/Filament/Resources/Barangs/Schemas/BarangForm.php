<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

use App\Models\Ruangan;
use App\Models\Barang;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('no_reg')
                    ->label('No. Reg')
                    ->numeric()
                    ->required(),

                TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                Select::make('unit')
                    ->label('Unit')
                    ->options(\App\Models\Ruangan::query()
                        ->select('unit')
                        ->distinct()
                        ->pluck('unit', 'unit'))
                    ->default(fn($record) => $record?->ruangan?->unit ?? Auth::user()->unit)
                    ->disabled(fn() => Auth::user()->role === 'Admin Unit') // jika admin unit, dikunci
                    ->reactive() // penting agar field Ruangan ikut berubah
                    ->required(),

                // 🔹 Ruangan hanya menampilkan ruangan dari unit tersebut
                Select::make('ruangan_id')
                    ->label('Ruangan')
                    ->options(function (callable $get) {
                        $unit = $get('unit');
                        if (!$unit) {
                            return \App\Models\Ruangan::pluck('ruangan', 'id');
                        }

                        return \App\Models\Ruangan::where('unit', $unit)
                            ->pluck('ruangan', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->reactive(), // agar update setiap unit berubah

                Select::make('status')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak' => 'Rusak',
                    ])
                    ->default('Baik')
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('progress_aksi', null)),

                Select::make('progress_aksi')
                    ->label('Progress Aksi')
                    ->options(function (callable $get) {
                        $status = $get('status');

                        return match ($status) {
                            'Baik' => [
                                'Aman' => 'Aman',
                            ],
                            'Rusak' => [
                                'Belum Ditindak' => 'Belum Ditindak',
                                'Sementara Ditindak' => 'Sementara Ditindak',
                                'Dibuang' => 'Dibuang',
                            ],
                            default => [
                                'Aman' => 'Aman',
                                'Belum Ditindak' => 'Belum Ditindak',
                                'Sementara Ditindak' => 'Sementara Ditindak',
                                'Dibuang' => 'Dibuang',
                            ],
                        };
                    })
                    ->required()
                    ->preload()
                    ->reactive(),

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
