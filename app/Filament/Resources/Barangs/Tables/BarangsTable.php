<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->query(
                Barang::query()->when(
                    $user->role !== 'Admin Utama',
                    fn($query) => $query->whereHas('ruangan', fn($q) => $q->where('unit', $user->unit))
                )
            )
            ->columns([
                TextColumn::make('No')
                    ->rowIndex()
                    ->label('No')
                    ->alignCenter(),
                TextColumn::make('no_reg')
                    ->label('No. Reg'),
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('ruangan.unit')
                    ->label('Unit'),
                TextColumn::make('ruangan.ruangan')
                    ->label('Ruangan'),
                TextColumn::make('status')
                    ->label('Status'),
                TextColumn::make('progress_aksi')
                    ->label('Progress Aksi'),
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
