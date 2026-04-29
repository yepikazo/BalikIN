<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory; // 2. Tambahkan ini
    protected $fillable = [
        'postingan_id',
        'user_id',
        'parent_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postingan()
    {
        return $this->belongsTo(Postingan::class, 'postingan_id');
    }

    // Relasi ke Komentar Induk (jika ini adalah sebuah balasan)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relasi ke Balasan-balasan (Children)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
