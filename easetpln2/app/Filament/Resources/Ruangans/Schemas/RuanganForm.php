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
                    ->required()
                    ->numeric(),
                TextInput::make('Unit')
                    ->required(),
                TextInput::make('Ruangan')
                    ->required(),
            ]);
    }
}
