<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Postingan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard Admin: ringkasan statistik + tabel postingan + laporan.
     */
    public function dashboard(): View
    {
        $stats = [
            'totalPostingan'   => Postingan::count(),
            'barangHilang'     => Postingan::where('jenis', 'barangHilang')->count(),
            'barangDitemukan'  => Postingan::where('jenis', 'barangDitemukan')->count(),
            'totalLaporan'     => Laporan::count(),
            'totalUser'        => User::where('role', 'pelapor')->count(),
        ];

        $postingans = Postingan::with('pelapor')
                               ->withCount('laporan')
                               ->latest()
                               ->paginate(10, ['*'], 'postingan_page');

        $laporans = Laporan::with(['pelapor', 'postingan'])
                           ->latest()
                           ->paginate(10, ['*'], 'laporan_page');

        return view('admin.dashboard', compact('stats', 'postingans', 'laporans'));
    }

    /**
     * Admin: hapus postingan manapun.
     */
    public function destroyPostingan(Postingan $postingan): RedirectResponse
    {
        if ($postingan->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($postingan->foto);
        }

        $postingan->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', "Postingan \"{$postingan->namaBarang}\" berhasil dihapus.");
    }

    /**
     * Admin: ubah status postingan.
     */
    public function updateStatusPostingan(Postingan $postingan): RedirectResponse
    {
        $newStatus = match ($postingan->status) {
            'dibuat'    => 'diamankan',
            'diamankan' => 'selesai',
            'selesai'   => 'dibuat',
        };

        $postingan->update(['status' => $newStatus]);

        return back()->with('success', "Status diubah menjadi: {$newStatus}.");
    }

    /**
     * Admin: hapus laporan (selesaikan laporan).
     */
    public function destroyLaporan(Laporan $laporan): RedirectResponse
    {
        $laporan->delete();

        return back()->with('success', 'Laporan berhasil diselesaikan.');
    }
}
