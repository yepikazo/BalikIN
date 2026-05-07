<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Postingan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────
    public function dashboard()
    {
        $totalPostingan = Postingan::count();
        $totalLaporan   = Laporan::count();
        $laporanPending = Laporan::where('status_laporan', 'pending')->count();
        $totalUser      = User::count();

        return view('admin.dashboard', compact(
            'totalPostingan',
            'totalLaporan',
            'laporanPending',
            'totalUser'
        ));
    }

    // ─── Kelola Postingan ─────────────────────────────────────
    public function daftarPostingan(Request $request)
    {
        $query = Postingan::with('user')->latest();

        // Filter tipe
        if ($request->filled('tipe') && in_array($request->tipe, ['hilang','ditemukan','diamankan','selesai','suspend'])) {
            $query->where('tipe', $request->tipe);
        }

        // Search nama barang / pemilik
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_barang', 'like', "%{$q}%")
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"));
            });
        }

        $postingan = $query->get();

        return view('admin.postingan', compact('postingan'));
    }

    /**
     * Admin mengubah tipe postingan:
     * bisa ke 'diamankan', 'selesai', 'suspend', atau kembali ke 'hilang'.
     */
    public function updateTipePostingan(Request $request, string $id)
    {
        $postingan = Postingan::findOrFail($id);

        $validated = $request->validate([
            'tipe' => 'required|in:hilang,ditemukan,diamankan,selesai,suspend',
        ]);

        $postingan->update(['tipe' => $validated['tipe']]);

        $pesan = match($validated['tipe']) {
            'diamankan' => 'Postingan ditandai sebagai Diamankan. Chat sekarang diarahkan ke admin.',
            'selesai'   => 'Postingan ditandai sebagai Selesai.',
            'suspend'   => 'Postingan berhasil disuspend.',
            default     => 'Tipe postingan berhasil diperbarui.',
        };

        return back()->with('success', $pesan);
    }

    // ─── Kelola Laporan ───────────────────────────────────────
    public function daftarLaporan()
    {
        $laporan = Laporan::with(['pelapor', 'postingan.user', 'admin'])->latest()->get();

        return view('admin.laporan', compact('laporan'));
    }

    public function updateStatusLaporan(Request $request, string $id)
    {
        $laporan   = Laporan::findOrFail($id);
        $postingan = Postingan::findOrFail($laporan->postingan_id);

        $validated = $request->validate([
            'status_laporan' => 'required|in:pending,disetujui,tolak',
        ]);

        $laporan->update([
            'status_laporan' => $validated['status_laporan'],
            'admin_id'       => Auth::id(),
        ]);

        // Jika laporan disetujui, otomatis suspend postingan terkait
        if ($validated['status_laporan'] === 'disetujui') {
            $postingan->update(['tipe' => 'suspend']);
        }

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    // ─── (Legacy) Direct suspend postingan ───────────────────
    public function updatePostinganFiktif(string $id)
    {
        $postingan = Postingan::findOrFail($id);
        $postingan->update(['tipe' => 'suspend']);

        return back()->with('success', 'Postingan berhasil disuspend.');
    }
}