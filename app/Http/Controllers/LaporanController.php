<?php

namespace App\Http\Controllers;

use App\Models\Postingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostinganController extends Controller
{
    // Menampilkan semua postingan (Beranda)
    public function index(Request $request)
    {
        // Mengambil data postingan terbaru, bisa ditambah filter pencarian nanti
        $postingan = Postingan::with('user')->latest()->get();
        
        // return view('postingan.index', compact('postingan')); // Nanti buat file view-nya
        return response()->json($postingan); // Sementara kembalikan JSON untuk tes
    }

    // Menampilkan form tambah postingan
    public function create()
    {
        return view('postingan.create');
    }

    // Menyimpan postingan baru ke database
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

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Tambahkan ID user yang sedang login
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'aktif';

        Postingan::create($validated);

        return redirect('/')->with('success', 'Postingan berhasil dibuat!');
    }

    // Menampilkan detail satu postingan beserta komentarnya
    public function show(string $id)
    {
        // Ambil postingan beserta user pembuatnya dan komentar (yang bukan balasan)
        $postingan = Postingan::with(['user', 'comments' => function ($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user']);
        }])->findOrFail($id);

        return view('postingan.show', compact('postingan'));
    }

    // Menampilkan form edit postingan
    public function edit(string $id)
    {
        $postingan = Postingan::findOrFail($id);

        // Keamanan: Pastikan yang edit adalah pemiliknya atau Admin
        if (Auth::id() !== $postingan->user_id && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Anda tidak berhak mengedit postingan ini.');
        }

        return view('postingan.edit', compact('postingan'));
    }

    // Menyimpan perubahan edit ke database
    public function update(Request $request, string $id)
    {
        $postingan = Postingan::findOrFail($id);

        if (Auth::id() !== $postingan->user_id && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Akses ditolak.');
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
            // Hapus foto lama dari storage
            if ($postingan->foto) {
                Storage::disk('public')->delete($postingan->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }

        $postingan->update($validated);

        return redirect('/postingan/' . $postingan->id)->with('success', 'Postingan diperbarui.');
    }

    // Menghapus postingan
    public function destroy(string $id)
    {
        $postingan = Postingan::findOrFail($id);

        if (Auth::id() !== $postingan->user_id && !Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        // Hapus foto dari storage sebelum menghapus data dari database
        if ($postingan->foto) {
            Storage::disk('public')->delete($postingan->foto);
        }

        $postingan->delete();

        return redirect('/')->with('success', 'Postingan berhasil dihapus.');
    }
}