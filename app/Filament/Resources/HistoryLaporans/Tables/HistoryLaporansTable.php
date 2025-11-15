<?php

namespace App\Filament\Resources\HistoryLaporans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HistoryLaporansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('no_reg')
                    ->searchable(),
                TextColumn::make('nama_barang')
                    ->searchable(),
                TextColumn::make('unit')
                    ->searchable(),
                TextColumn::make('ruangan')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('progress_aksi')
                    ->searchable(),
                TextColumn::make('tanggal_laporan')
                    ->date()
                    ->sortable(),
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
