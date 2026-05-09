<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Menampilkan daftar percakapan (Inbox).
     */
    public function index()
    {
        $userId = Auth::id();

        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get();

        $seen          = [];
        $conversations = [];

        foreach ($messages as $msg) {
            $otherId   = $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
            $otherUser = $msg->sender_id === $userId ? $msg->receiver    : $msg->sender;

            if (!isset($seen[$otherId])) {
                $seen[$otherId] = true;
                $unread = Message::where('sender_id', $otherId)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();

                $conversations[] = [
                    'user'         => $otherUser,
                    'last_message' => $msg,
                    'unread'       => $unread,
                ];
            }
        }

        return view('pesan.index', compact('conversations'));
    }

    /**
     * Menampilkan halaman percakapan.
     * Mendeteksi referensi postingan dari conversation untuk mention card (tampil ke kedua sisi).
     */
    public function show(int $userId)
    {
        $currentId = Auth::id();
        $otherUser = User::findOrFail($userId);

        if ($userId === $currentId) {
            return redirect()->route('pesan.index')->with('error', 'Anda tidak dapat chat dengan diri sendiri.');
        }

        $messages = Message::where(fn($q) => $q->where('sender_id', $currentId)->where('receiver_id', $userId))
            ->orWhere(fn($q) => $q->where('sender_id', $userId)->where('receiver_id', $currentId))
            ->orderBy('created_at')
            ->get();


        Message::where('sender_id', $userId)
            ->where('receiver_id', $currentId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('pesan.show', compact('otherUser', 'messages'));
    }

    /**
     * Kirim pesan baru — bisa sertakan postingan_id sebagai konteks.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id'  => 'required|exists:users,id',
            'body'         => 'required|string|max:1000',

        ]);

        if ($validated['receiver_id'] == Auth::id()) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['error' => 'Anda tidak bisa mengirim pesan ke diri sendiri.'], 422);
            }
            return back()->with('error', 'Anda tidak bisa mengirim pesan ke diri sendiri.');
        }

        $validated['sender_id'] = Auth::id();
        $validated['is_read']   = false;

        $message = Message::create($validated);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json(['message' => $message, 'status' => 'sent']);
        }

        return redirect()->route('pesan.show', $validated['receiver_id'])
            ->with('success', 'Pesan berhasil dikirim.');
    }

    /**
     * Edit pesan — hanya pengirim.
     */
    public function update(Request $request, int $id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Tidak diizinkan.'], 403);
        }

        $validated = $request->validate(['body' => 'required|string|max:1000']);
        $message->update(['body' => $validated['body']]);

        return response()->json(['message' => $message, 'status' => 'updated']);
    }

    /**
     * Hapus pesan — hanya pengirim.
     */
    public function destroy(int $id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Tidak diizinkan.'], 403);
        }

        $message->delete();
        return response()->json(['status' => 'deleted']);
    }
}
