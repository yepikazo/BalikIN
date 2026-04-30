<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Menyimpan laporan dari user ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'postingan_id' => 'required|exists:postingan,id',
            'alasan'       => 'required|string|max:1000',
        ]);

        // Tambahkan ID pelapor, tanggal, dan status default
        $validated['pelapor_id'] = Auth::id();
        $validated['tanggal_laporan'] = now();
        $validated['status_laporan'] = 'pending';

        Laporan::create($validated);

        // Kembalikan user ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Laporan berhasil dikirim dan akan segera ditinjau oleh Admin.');
    }
}