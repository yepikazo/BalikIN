<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $messages = Message::with(['sender', 'receiver'])
            ->where('sender_id', $userId)->orWhere('receiver_id', $userId)
            ->orderByDesc('created_at')->get();

        $seen = [];
        $conversations = [];
        foreach ($messages as $msg) {
            $otherId   = $msg->sender_id === $userId ? $msg->receiver_id : $msg->sender_id;
            $otherUser = $msg->sender_id === $userId ? $msg->receiver : $msg->sender;
            if (!isset($seen[$otherId])) {
                $seen[$otherId] = true;
                $conversations[] = ['id' => $otherId, 'name' => $otherUser->name ?? 'Unknown', 'lastMessage' => $msg->body];
            }
        }
        return response()->json($conversations);
    }

    public function messages($userId)
    {
        $currentId = Auth::id();
        $messages = Message::where(fn($q) => $q->where('sender_id', $currentId)->where('receiver_id', $userId))
            ->orWhere(fn($q) => $q->where('sender_id', $userId)->where('receiver_id', $currentId))
            ->orderBy('created_at')->get()
            ->map(fn($m) => ['id' => $m->id, 'body' => $m->body, 'sender_id' => $m->sender_id]);
        return response()->json($messages);
    }
}
