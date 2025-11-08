<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->numeric()
                    ->label('No.')
                    ->sortable(),
                TextColumn::make('no_reg')
                    ->numeric()
                    ->label('No. Reg')
                    ->sortable(),
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('unit')
                    ->label('Unit')
                    ->sortable(),
                TextColumn::make('ruangan')
                    ->label('Ruangan')
                    ->sortable(),
                TextColumn::make('status'),
                TextColumn::make('progress_aksi'),
                TextColumn::make('deskripsi')
                    ->searchable(),
                TextColumn::make('urgensi'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
