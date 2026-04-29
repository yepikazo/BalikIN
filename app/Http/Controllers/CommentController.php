<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Menyimpan komentar utama atau balasan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'postingan_id' => 'required|exists:postingan,id',
            'parent_id'    => 'nullable|exists:comments,id', // Diisi jika membalas komentar
            'content'      => 'required|string',
        ]);

        // Tambahkan ID user yang sedang login
        $validated['user_id'] = Auth::id();

        Comment::create($validated);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    // Menghapus komentar
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);

        // Hanya pemilik komentar atau Admin yang bisa menghapus
        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'Akses ditolak.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}