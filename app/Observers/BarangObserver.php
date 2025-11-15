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
        // Pastikan hanya jalan sekali untuk create baru
        if ($barang->wasRecentlyCreated === false) {
            return;
        }

        $ruangan = $barang->ruangan;

        HistoryLaporan::create([
            'no_reg' => $barang->no_reg ?? '-',
            'nama_barang' => $barang->nama_barang,
            'unit' => $ruangan?->unit ?? '-',
            'ruangan' => $ruangan?->ruangan ?? '-',
            'status' => $barang->status,
            'progress_aksi' => $barang->progress_aksi,
            'deskripsi' => "Barang {$barang->nama_barang} di di {$ruangan?->unit} {$ruangan?->ruangan} berhasil ditambahkan ke sistem.",
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
            'status' => $barang->status,
            'progress_aksi' => $barang->progress_aksi,
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
