<?php

namespace App\Filament\Resources\Barangs;

use App\Filament\Resources\Barangs\Pages\CreateBarang;
use App\Filament\Resources\Barangs\Pages\EditBarang;
use App\Filament\Resources\Barangs\Pages\ListBarangs;
use App\Filament\Resources\Barangs\Schemas\BarangForm;
use App\Filament\Resources\Barangs\Tables\BarangsTable;
use App\Models\Barang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\Ruangan;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Barang';
    protected static ?string $navigationLabel = 'Kelola Barang';
    protected static ?string $pluralLabel = 'Barang';
    protected static ?string $modelLabel = 'Barang';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('no')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(fn() => \App\Models\Barang::max('no') + 1),

                Forms\Components\TextInput::make('no_reg')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('nama_barang')
                    ->required()
                    ->maxLength(255),

                Select::make('unit')
                    ->label('Unit')
                    ->options(Ruangan::pluck('unit', 'unit'))
                    ->required(),

                Select::make('ruangan_id')
                    ->label('Ruangan')
                    ->relationship('ruangan', 'ruangan')
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->options([
                        'Baik' => 'Baik',
                        'Perlu Diperbaiki' => 'Perlu Diperbaiki',
                        'Rusak' => 'Rusak',
                    ])
                    ->default('Baik'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return BarangsTable::configure($table);
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
            'index' => ListBarangs::route('/'),
            'create' => CreateBarang::route('/create'),
            'edit' => EditBarang::route('/{record}/edit'),
        ];
    }
}
