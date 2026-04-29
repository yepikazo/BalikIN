<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostinganRequest;
use App\Models\Postingan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostinganController extends Controller
{
    /**
     * Tampilkan feed / beranda: semua postingan, bisa difilter & dicari.
     */
    public function index(Request $request): View
    {
        $query = Postingan::with('pelapor')->latest();

        // Filter berdasarkan jenis
        if ($request->filled('jenis') && in_array($request->jenis, ['barangHilang', 'barangDitemukan'])) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian by nama barang atau lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('namaBarang', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $postingans = $query->paginate(12)->withQueryString();

        return view('postingan.index', compact('postingans'));
    }

    /**
     * Tampilkan form buat postingan baru.
     */
    public function create(): View
    {
        $this->authorize('create', Postingan::class);

        return view('postingan.create');
    }

    /**
     * Simpan postingan baru ke database.
     */
    public function store(StorePostinganRequest $request): RedirectResponse
    {
        $this->authorize('create', Postingan::class);

        $data = $request->validated();
        $data['id_pelapor'] = Auth::id();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('postingan', 'public');
        } else {
            $data['foto'] = null;
        }

        Postingan::create($data);

        return redirect()->route('postingan.index')
                         ->with('success', 'Postingan berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail postingan.
     */
    public function show(Postingan $postingan): View
    {
        $this->authorize('view', $postingan);

        $postingan->load(['pelapor', 'laporan.pelapor']);

        return view('postingan.show', compact('postingan'));
    }

    /**
     * Tampilkan form edit postingan.
     */
    public function edit(Postingan $postingan): View
    {
        $this->authorize('update', $postingan);

        return view('postingan.edit', compact('postingan'));
    }

    /**
     * Update postingan di database.
     */
    public function update(StorePostinganRequest $request, Postingan $postingan): RedirectResponse
    {
        $this->authorize('update', $postingan);

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($postingan->foto) {
                Storage::disk('public')->delete($postingan->foto);
            }
            $data['foto'] = $request->file('foto')->store('postingan', 'public');
        }

        $postingan->update($data);

        return redirect()->route('postingan.show', $postingan)
                         ->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * Hapus postingan.
     */
    public function destroy(Postingan $postingan): RedirectResponse
    {
        $this->authorize('delete', $postingan);

        if ($postingan->foto) {
            Storage::disk('public')->delete($postingan->foto);
        }

        $postingan->delete();

        return redirect()->route('postingan.index')
                         ->with('success', 'Postingan berhasil dihapus.');
    }
}
