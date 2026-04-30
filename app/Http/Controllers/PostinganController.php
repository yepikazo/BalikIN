<?php

namespace App\Http\Controllers;

use App\Models\Postingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostinganController extends Controller
{
    // 1. Menampilkan semua postingan (Halaman Beranda)
    public function index(Request $request)
    {
        // Mengambil data postingan terbaru beserta data user pembuatnya
        // Nanti Anda bisa menambahkan logika filter di sini (misal filter berdasarkan $request->kategori)
        $postingan = Postingan::with('user')->latest()->get();
        
        // Memanggil komponen view postingan/index.blade.php
        return view('postingan.index', compact('postingan')); 
    }

    // 2. Menampilkan form tambah postingan
    public function create()
    {
        return view('postingan.create');
    }

    // 3. Menyimpan postingan baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:hilang,ditemukan',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'waktu_kejadian' => 'required|date',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // Proses upload foto jika user melampirkan foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Otomatis tambahkan ID user yang sedang login dan status default
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'aktif';

        Postingan::create($validated);

        return redirect()->route('beranda')->with('success', 'Postingan berhasil dibuat!');
    }

    // 4. Menampilkan detail satu postingan beserta komentarnya
    public function show(string $id)
    {
        // Ambil postingan + user pembuatnya + komentar utama (parent_id = null) beserta balasannya
        $postingan = Postingan::with(['user', 'comments' => function ($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }])->findOrFail($id);

        return view('postingan.show', compact('postingan'));
    }

    // 5. Menampilkan form edit postingan
    public function edit(string $id)
    {
        $postingan = Postingan::findOrFail($id);

        // FITUR KEAMANAN: Pastikan yang edit adalah pemiliknya atau Admin
        if (Auth::id() !== $postingan->user_id && !Auth::user()->is_admin) {
            return redirect()->route('beranda')->with('error', 'Anda tidak berhak mengedit postingan ini.');
        }

        return view('postingan.edit', compact('postingan'));
    }

    // 6. Menyimpan perubahan edit ke database
    public function update(Request $request, string $id)
    {
        $postingan = Postingan::findOrFail($id);

        // Pengecekan keamanan ulang
        if (Auth::id() !== $postingan->user_id && !Auth::user()->is_admin) {
            return redirect()->route('beranda')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'tipe' => 'required|in:hilang,ditemukan',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'waktu_kejadian' => 'required|date',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,selesai',
        ]);

        // Proses ganti foto jika ada foto baru yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage publik jika sebelumnya ada foto
            if ($postingan->foto) {
                Storage::disk('public')->delete($postingan->foto);
            }
            // Simpan foto yang baru
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }

        $postingan->update($validated);

        return redirect()->route('postingan.show', $postingan->id)->with('success', 'Postingan berhasil diperbarui.');
    }

    // 7. Menghapus postingan
    public function destroy(string $id)
    {
        $postingan = Postingan::findOrFail($id);

        // Pengecekan keamanan: Hanya pemilik atau admin yang bisa hapus
        if (Auth::id() !== $postingan->user_id && !Auth::user()->is_admin) {
            return redirect()->route('beranda')->with('error', 'Akses ditolak.');
        }

        // Hapus file foto fisik dari folder storage sebelum menghapus data dari database
        if ($postingan->foto) {
            Storage::disk('public')->delete($postingan->foto);
        }

        $postingan->delete();

        return redirect()->route('beranda')->with('success', 'Postingan berhasil dihapus.');
    }
}