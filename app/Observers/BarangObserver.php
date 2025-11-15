<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\HistoryLaporan;

class BarangObserver
{
    /**
     * Handle the Barang "created" event.
     */
    public function created(Barang $barang): void
    {
        info('Observer Barang jalan!');

        $ruangan = $barang->ruangan;

        HistoryLaporan::create([
            'no_reg' => $barang->no_reg ?? '-',
            'nama_barang' => $barang->nama_barang,
            'unit' => $ruangan?->unit ?? '-',
            'ruangan' => $ruangan?->ruangan ?? '-',
            'deskripsi' => "Barang {$barang->nama_barang} berhasil ditambahkan ke sistem.",
            'tanggal_laporan' => now(),
        ]);
    }

    /**
     * Handle the Barang "updated" event.
     */
    public function updated(Barang $barang): void
    {
        $ruangan = $barang->ruangan()->first();

        HistoryLaporan::update([
            'no' => $barang->id,
            'no_reg' => $barang->no_reg ?? '-',
            'nama_barang' => $barang->nama_barang,
            'unit' => $ruangan?->unit ?? '-',
            'ruangan' => $ruangan?->ruangan ?? '-',
            'deskripsi' => "Perubahan data pada barang {$barang->nama_barang} di {$ruangan?->unit} {$ruangan?->ruangan}.",
            'tanggal_laporan' => now(),
        ]);
    }

    /**
     * Handle the Barang "deleted" event.
     */
    public function deleted(Barang $barang): void
    {
        //
    }

    /**
     * Handle the Barang "restored" event.
     */
    public function restored(Barang $barang): void
    {
        //
    }

    /**
     * Handle the Barang "force deleted" event.
     */
    public function forceDeleted(Barang $barang): void
    {
        //
    }
}
