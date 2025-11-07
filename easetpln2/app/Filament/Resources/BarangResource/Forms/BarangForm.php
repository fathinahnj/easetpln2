<?php

namespace App\Filament\Resources\YourResourceName\Pages;

use App\Filament\Resources\Ruangans\RuanganResource;
use Filament\Actions;;

use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Select;

class EditYourResourceName extends EditRecord
{
  protected static string $resource = RuanganResource::class;

  protected function getFormSchema(): array
  {
    return [
      // ...existing fields...

      Select::make('status')
        ->options([
          'Baik' => 'Baik',
          'Rusak' => 'Rusak',
          'Perlu Diperbaiki' => 'Perlu Diperbaiki',
        ])
        ->default('Baik')
        ->reactive(),

      Select::make('progress_aksi')
        ->options(function (callable $get) {
          $status = $get('status');

          return match ($status) {
            'Baik' => [
              'Tidak Ada' => 'Tidak Ada',
            ],
            'Rusak' => [
              'Perlu Diganti' => 'Perlu Diganti',
              'Dibuang' => 'Dibuang',
            ],
            'Perlu Diperbaiki' => [
              'Belum Ditindak' => 'Belum Ditindak',
              'Sementara Diperbaiki' => 'Sementara Diperbaiki',
            ],
            default => [],
          };
        })
        ->required()
        ->default('Tidak Ada'),

      // ...existing fields...
    ];
  }

  protected function getActions(): array
  {
    return [
      Actions\EditAction::make(),
      Actions\DeleteAction::make(),
    ];
  }
}
