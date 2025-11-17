<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex()
                    ->label('No')
                    ->alignCenter(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role')
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Unit')
                    ->searchable(),
                TextColumn::make('whatsapp')
                    ->label('Nomor WhatsApp')
                    ->formatStateUsing(fn($state) => "
                        <a href='https://wa.me/{$state}'
                        target='_blank'
                        style='color:#25D366; font-weight:600; text-decoration:none; display:flex; align-items:center; gap:6px;'>
                            <img src='https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg'
                                width='16' height='16' alt='WA'>
                            {$state}
                        </a>
    ")
                    ->html(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->label('')
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('')
                    ->color('danger')
                    ->tooltip('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
