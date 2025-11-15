<?php

namespace App\Filament\Resources\Ruangans;

use App\Filament\Resources\Ruangans\Pages\CreateRuangan;
use App\Filament\Resources\Ruangans\Pages\EditRuangan;
use App\Filament\Resources\Ruangans\Pages\ListRuangans;
use App\Filament\Resources\Ruangans\Schemas\RuanganForm;
use App\Filament\Resources\Ruangans\Tables\RuangansTable;
use App\Models\Ruangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Form;

class RuanganResource extends Resource
{
    protected static ?string $model = Ruangan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'Unit/Ruangan';
    protected static ?string $navigationLabel = 'Kelola Unit/Ruangan';
    protected static ?string $pluralLabel = 'Ruangan';
    protected static ?string $modelLabel = 'Ruangan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('No')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(fn() => \App\Models\Ruangan::max('No') + 1),

                Forms\Components\TextInput::make('unit')
                    ->label('Unit')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('ruangan')
                    ->label('Ruangan')
                    ->required()
                    ->maxLength(255),
            ]);
        // return RuanganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RuangansTable::configure($table);
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
            'index' => ListRuangans::route('/'),
            'create' => CreateRuangan::route('/create'),
            'edit' => EditRuangan::route('/{record}/edit'),
        ];
    }
}
