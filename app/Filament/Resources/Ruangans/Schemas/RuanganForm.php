<?php

namespace App\Filament\Resources\Ruangans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RuanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('No')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(fn() => \App\Models\Ruangan::max('No') + 1),

                TextInput::make('unit')
                    ->label('Unit')
                    ->required()
                    ->maxLength(255),

                TextInput::make('ruangan')
                    ->label('Ruangan')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
