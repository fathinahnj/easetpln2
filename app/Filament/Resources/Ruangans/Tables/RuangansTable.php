<?php

namespace App\Filament\Resources\Ruangans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RuangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->numeric()
                    ->label('No.')
                    ->rowIndex()
                    ->sortable(),
                TextColumn::make('Unit')
                    ->label('Unit')
                    ->searchable(),
                TextColumn::make('Ruangan')
                    ->label('Ruangan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->tooltip('Edit data ruangan'),
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
                    DeleteBulkAction::make()
                        ->label('Hapus pilihan'),
                ]),
            ]);
    }
}
