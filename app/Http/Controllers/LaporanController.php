<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanRequest;
use App\Models\Laporan;
use App\Models\Postingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Simpan laporan postingan fiktif/palsu.
     * Pelapor tidak bisa melaporkan postingannya sendiri.
     */
    public function store(StoreLaporanRequest $request): RedirectResponse
    {
        $postingan = Postingan::findOrFail($request->id_postingan);

        // Cegah laporan postingan sendiri
        if ($postingan->id_pelapor === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa melaporkan postingan milik Anda sendiri.');
        }

        // Cegah laporan duplikat
        $sudahDilaporkan = Laporan::where('id_pelapor', Auth::id())
                                  ->where('id_postingan', $postingan->id)
                                  ->exists();

        if ($sudahDilaporkan) {
            return back()->with('error', 'Anda sudah melaporkan postingan ini sebelumnya.');
        }

        Laporan::create([
            'id_pelapor'   => Auth::id(),
            'id_postingan' => $postingan->id,
            'alasan'       => $request->alasan,
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Terima kasih!');
    }

    /**
     * Admin: hapus laporan (selesaikan/tolak laporan).
     */
    public function destroy(Laporan $laporan): RedirectResponse
    {
        $laporan->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
