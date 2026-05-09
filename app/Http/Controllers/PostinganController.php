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
        $query = Postingan::with('user')->whereNotIn('tipe', ['suspend', 'selesai'])->latest();

        // Filter berdasarkan tipe (hilang/ditemukan)
        if ($request->filled('tipe') && in_array($request->tipe, ['hilang', 'ditemukan', 'diamankan'])) {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Search berdasarkan nama_barang, deskripsi, atau lokasi
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $postingan = $query->get();

        // Ambil semua kategori unik untuk dropdown filter
        $kategoriList = Postingan::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('postingan.index', compact('postingan', 'kategoriList'));
    }

    // 2. Menampilkan form tambah postingan
    public function create()
    {
        return view('postingan.create');
    }

    // 3. Menyimpan postingan baru ke database
    public function store(Request $request)
    {
        // Admin boleh memilih tipe 'diamankan', user biasa hanya hilang/ditemukan
        $allowedTipe = Auth::user()->is_admin
            ? 'required|in:hilang,ditemukan,diamankan'
            : 'required|in:hilang,ditemukan';

        $validated = $request->validate([
            'tipe'           => $allowedTipe,
            'nama_barang'    => 'required|string|max:255',
            'kategori'       => 'required|string|max:255',
            'lokasi'         => 'required|string|max:255',
            'waktu_kejadian' => 'required|date',
            'deskripsi'      => 'required|string',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses upload foto jika user melampirkan foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_barang', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Otomatis tambahkan ID user yang sedang login dan status default
        $validated['user_id'] = Auth::id();

        $postingan = Postingan::create($validated);

        // Smart redirect: kembali ke asal jika ada redirect_back (misal admin)
        $redirectBack = $request->input('redirect_back');
        if ($redirectBack && Auth::user()->is_admin) {
            return redirect($redirectBack)->with('success', 'Postingan berhasil dibuat!');
        }

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

        if ($postingan->tipe === 'diamankan' && !Auth::user()->is_admin) {
            return redirect()->route('beranda')->with('error', 'Postingan ini sedang diamankan oleh admin dan tidak dapat diedit.');
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

        if ($postingan->tipe === 'diamankan' && !Auth::user()->is_admin) {
            return redirect()->route('beranda')->with('error', 'Postingan ini sedang diamankan oleh admin dan tidak dapat diedit.');
        }

        // Admin boleh memilih tipe 'diamankan', user biasa hanya hilang/ditemukan
        $allowedTipe = Auth::user()->is_admin
            ? 'required|in:hilang,ditemukan,diamankan'
            : 'required|in:hilang,ditemukan';

        $validated = $request->validate([
            'tipe'           => $allowedTipe,
            'nama_barang'    => 'required|string|max:255',
            'kategori'       => 'required|string|max:255',
            'lokasi'         => 'required|string|max:255',
            'waktu_kejadian' => 'required|date',
            'deskripsi'      => 'required|string',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
        } elseif ($request->input('remove_foto') == '1') {
            if ($postingan->foto) {
                Storage::disk('public')->delete($postingan->foto);
            }
            $validated['foto'] = null;
        }

        $postingan->update($validated);

        // Smart redirect: kembali ke asal jika admin mengisi redirect_back
        $redirectBack = $request->input('redirect_back');
        if ($redirectBack && Auth::user()->is_admin) {
            return redirect($redirectBack)->with('success', 'Postingan berhasil diperbarui.');
        }

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

        if ($postingan->tipe === 'diamankan' && !Auth::user()->is_admin) {
            return redirect()->route('beranda')->with('error', 'Postingan ini sedang diamankan oleh admin dan tidak dapat dihapus.');
        }

        // Hapus file foto fisik dari folder storage sebelum menghapus data dari database
        if ($postingan->foto) {
            Storage::disk('public')->delete($postingan->foto);
        }

        $postingan->delete();
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.postingan.index')->with('success', 'Postingan berhasil dihapus.');
        }
        return redirect()->route('beranda')->with('success', 'Postingan berhasil dihapus.');
    }

    // 8. Menampilkan postingan milik user yang sedang login
    public function myPosts()
    {
        $postingan = Postingan::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('postingan.saya', compact('postingan'));
    }
}