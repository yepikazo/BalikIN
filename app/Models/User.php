<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // --- RELASI ---

    // User memiliki banyak postingan
    public function postingan()
    {
        return $this->hasMany(Postingan::class);
    }

    // User memiliki banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // User sebagai pelapor dalam tabel laporan
    public function laporanDibuat()
    {
        return $this->hasMany(Laporan::class, 'pelapor_id');
    }

    // Relasi untuk Messenger (Pesan Terkirim)
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Relasi untuk Messenger (Pesan Diterima)
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}