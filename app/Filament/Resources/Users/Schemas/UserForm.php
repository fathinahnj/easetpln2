<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                Select::make('role')
                    ->options([
                        'Admin Utama' => 'Admin Utama',
                        'Admin Unit' => 'Admin Unit',
                    ])->required(),
                TextInput::make('whatsapp')
                    ->label('Nomor WhatsApp (format: wa.me/62...)')
                    ->required(),
            ]);
    }
}
