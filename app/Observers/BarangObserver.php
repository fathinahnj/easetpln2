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
        // Pastikan hanya berjalan sekali saat create baru
        if (!$barang->wasRecentlyCreated) {
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
        $ruangan = $barang->ruangan;

        // Deteksi perubahan status
        if ($barang->isDirty('status')) {
            $statusLama = $barang->getOriginal('status');
            $statusBaru = $barang->status;

            HistoryLaporan::create([
                'no_reg' => $barang->no_reg ?? '-',
                'nama_barang' => $barang->nama_barang ?? '-',
                'unit' => $ruangan?->unit ?? '-',
                'ruangan' => $ruangan?->ruangan ?? '-',
                'status' => $statusBaru,
                'progress_aksi' => 'Status barang diperbarui',
                'deskripsi' => "Status barang {$barang->nama_barang} berubah dari '{$statusLama}' menjadi '{$statusBaru}'.",
                'tanggal_laporan' => now(),
            ]);
        }
    }

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
