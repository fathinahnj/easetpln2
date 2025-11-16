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
            TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
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
