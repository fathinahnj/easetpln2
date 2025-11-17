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

                TextInput::make('unit')
                    ->label('Unit')
                    ->default(fn($record) => $record?->ruangan?->unit ?? Auth::user()->unit)
                    ->disabled() // hanya tampilkan, tidak bisa diubah
                    ->dehydrated(false),

                // 🔹 Ruangan hanya menampilkan ruangan dari unit tersebut
                Select::make('ruangan_id')
                    ->label('Ruangan')
                    ->options(function () {
                        $user = Auth::user();
                        if ($user->role === 'Admin Utama') {
                            return Ruangan::pluck('ruangan', 'id');
                        }
                        // Admin Unit hanya lihat ruangan milik unit-nya
                        return Ruangan::where('unit', $user->unit)->pluck('ruangan', 'id');
                    })
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak' => 'Rusak',
                    ])
                    ->default('Baik')
                    ->reactive(),

                Select::make('progress_aksi')
                    ->label('Progress Aksi')
                    ->options(function (callable $get) {
                        $status = $get('status');
                        return match ($status) {
                            'Baik' => ['Aman' => 'Aman'],
                            'Rusak' => ['Belum Ditindak' => 'Belum Ditindak', 'Sementara Ditindak' => 'Sementara Ditindak', 'Dibuang' => 'Dibuang'],
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
