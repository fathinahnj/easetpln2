<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\HistoryLaporan;

class BarangObserver
{
    public function created(Barang $barang): void
    {
        $ruangan = $barang->ruangan;

        HistoryLaporan::create([
            'no_reg' => $barang->no_reg ?? '-',
            'nama_barang' => $barang->nama_barang,
            'unit' => $ruangan?->unit ?? '-',
            'ruangan' => $ruangan?->ruangan ?? '-',
            'status' => $barang->status,
            'progress_aksi' => $barang->progress_aksi,
            'deskripsi' => "Barang {$barang->nama_barang} di {$ruangan?->unit} {$ruangan?->ruangan} berhasil ditambahkan ke sistem.",
            'tanggal_laporan' => now(),
        ]);
    }

    /**
     * Handle only when Barang is updated (not created)
     */
    public function updating(Barang $barang): void
    {
        // Hanya jalan kalau memang ada perubahan status
        if ($barang->isDirty('status')) {
            $statusLama = $barang->getOriginal('status');
            $statusBaru = $barang->status;

            $ruangan = $barang->ruangan;

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
}
