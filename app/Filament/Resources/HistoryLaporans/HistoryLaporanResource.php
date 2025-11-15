<?php

namespace App\Filament\Resources\HistoryLaporans;

use App\Filament\Resources\HistoryLaporans\Pages\CreateHistoryLaporan;
use App\Filament\Resources\HistoryLaporans\Pages\EditHistoryLaporan;
use App\Filament\Resources\HistoryLaporans\Pages\ListHistoryLaporans;
use App\Filament\Resources\HistoryLaporans\Pages\ViewHistoryLaporan;
use App\Filament\Resources\HistoryLaporans\Schemas\HistoryLaporanForm;
use App\Filament\Resources\HistoryLaporans\Schemas\HistoryLaporanInfolist;
use App\Filament\Resources\HistoryLaporans\Tables\HistoryLaporansTable;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\HistoryLaporanResource\Pages;
use App\Models\HistoryLaporan;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Schemas\Schema;

class HistoryLaporanResource extends Resource
{
    protected static ?string $model = HistoryLaporan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'History Laporan';

    protected static ?string $recordTitleAttribute = 'History';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('no')
                    ->label('No')
                    ->disabled()
                    ->dehydrated(false) // agar tidak dikirim ke database (readonly)
                    ->default(fn() => \App\Models\Barang::max('no') + 1),

                // Tambahkan field lainnya di bawah ini
                Forms\Components\TextInput::make('no_reg')->label('No. Reg'),
                Forms\Components\TextInput::make('nama_barang')->label('Nama Barang'),
                Forms\Components\TextInput::make('unit')
                    ->label('Unit')
                    ->disabled(),

                Forms\Components\TextInput::make('ruangan')
                    ->label('Ruangan')
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Baik' => 'Baik',
                        'Perlu Diperbaiki' => 'Perlu Diperbaiki',
                        'Rusak' => 'Rusak',
                    ]),
                Forms\Components\Textarea::make('deskripsi')->label('Deskripsi'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HistoryLaporanInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHistoryLaporans::route('/'),
            'create' => CreateHistoryLaporan::route('/create'),
            'view' => ViewHistoryLaporan::route('/{record}'),
            'edit' => EditHistoryLaporan::route('/{record}/edit'),
        ];
    }
}
