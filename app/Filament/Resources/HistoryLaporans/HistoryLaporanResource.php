<?php

namespace App\Filament\Resources\HistoryLaporans;

use App\Filament\Resources\HistoryLaporans\Pages\CreateHistoryLaporan;
use App\Filament\Resources\HistoryLaporans\Pages\EditHistoryLaporan;
use App\Filament\Resources\HistoryLaporans\Pages\ListHistoryLaporans;
use App\Filament\Resources\HistoryLaporans\Pages\ViewHistoryLaporan;
use App\Filament\Resources\HistoryLaporans\Schemas\HistoryLaporanForm;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\HistoryLaporans\Schemas\HistoryLaporanInfolist;

class HistoryLaporanResource extends Resource
{
    protected static ?string $model = HistoryLaporan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $recordTitleAttribute = 'History Laporan';
    protected static ?string $navigationLabel = 'History Laporan';
    protected static ?string $pluralLabel = 'History Laporan';
    protected static ?string $modelLabel = 'History Laporan';


    public static function form(Schema $schema): Schema
    {
        return HistoryLaporanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HistoryLaporansTable::table($table);
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Auth::user()->role !== 'Admin Utama') {
            $query->where('unit', Auth::user()->unit);
        }

        return $query;
    }
}
