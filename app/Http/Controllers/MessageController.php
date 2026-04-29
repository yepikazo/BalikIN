<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Menampilkan daftar percakapan (Inbox)
    public function index()
    {
        $userId = Auth::id();
        
        // Ambil semua pesan di mana user sebagai pengirim atau penerima
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        // Nanti bisa dikelompokkan berdasarkan user untuk tampilan daftar chat
        return view('messages.index', compact('messages'));
    }

    // Mengirim pesan baru ke user tertentu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body'        => 'required|string',
        ]);

        // Pastikan tidak mengirim pesan ke diri sendiri
        if ($validated['receiver_id'] == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa mengirim pesan ke diri sendiri.');
        }

        $validated['sender_id'] = Auth::id();

        Message::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}