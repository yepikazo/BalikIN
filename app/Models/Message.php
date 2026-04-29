<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory; // 2. Tambahkan ini
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'body',
        'is_read',
    ];

    // Pengirim Pesan
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Penerima Pesan
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
