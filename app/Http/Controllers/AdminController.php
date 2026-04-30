<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Postingan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Halaman Dashboard Utama Admin
    public function dashboard()
    {
        // Mengambil statistik sederhana untuk ditampilkan
        $totalPostingan = Postingan::count();
        $totalLaporan = Laporan::count();
        $laporanPending = Laporan::where('status_laporan', 'pending')->count();
        $totalUser = User::count();

        return view('admin.dashboard', compact('totalPostingan', 'totalLaporan', 'laporanPending', 'totalUser'));
    }

    // Menampilkan daftar semua laporan fiktif
    public function daftarLaporan()
    {
        // Ambil data laporan beserta relasi pelapor, postingannya, dan admin yang menangani
        $laporan = Laporan::with(['pelapor', 'postingan', 'admin'])->latest()->get();
        
        return view('admin.laporan', compact('laporan'));
    }

    // Mengubah status laporan (misal dari "pending" jadi "diproses" atau "selesai")
    public function updateStatusLaporan(Request $request, string $id)
    {
        $laporan = Laporan::findOrFail($id);
        
        $validated = $request->validate([
            'status_laporan' => 'required|in:pending,diproses,selesai',
        ]);

        // Update status dan catat ID Admin yang melakukan aksi tersebut
        $laporan->update([
            'status_laporan' => $validated['status_laporan'],
            'admin_id'       => Auth::id(), 
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    // Admin menghapus postingan yang terbukti fiktif (langsung dari halaman laporan)
    public function hapusPostinganFiktif(string $id)
    {
        $postingan = Postingan::findOrFail($id);
        
        // Hapus file foto dari storage jika ada
        if ($postingan->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($postingan->foto);
        }

        $postingan->delete();
        // Catatan: Karena kita pakai cascadeOnDelete di migrasi, otomatis 
        // laporan dan komentar yang terkait postingan ini juga ikut terhapus di database!

        return back()->with('success', 'Postingan fiktif berhasil dihapus beserta laporannya.');
    }
}