<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Menampilkan riwayat laporan yang dibuat user yang sedang login.
     */
    public function index()
    {
        $laporan = Laporan::with(['postingan.user', 'admin'])
            ->where('pelapor_id', Auth::id())
            ->latest('tanggal_laporan')
            ->get();

        return view('laporan.index', compact('laporan'));
    }

    /**
     * Menyimpan laporan baru dari user ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'postingan_id' => 'required|exists:postingan,id',
            'alasan'       => 'required|string|max:1000',
        ]);

        // Cek apakah user sudah pernah melaporkan postingan ini
        $existing = Laporan::where('pelapor_id', Auth::id())
            ->where('postingan_id', $validated['postingan_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah pernah melaporkan postingan ini sebelumnya.');
        }

        // Tambahkan ID pelapor, tanggal, dan status default
        $validated['pelapor_id']     = Auth::id();
        $validated['tanggal_laporan'] = now();
        $validated['status_laporan'] = 'pending';

        Laporan::create($validated);

        return back()->with('success', 'Laporan berhasil dikirim dan akan segera ditinjau oleh Admin.');
    }
}