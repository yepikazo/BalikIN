<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Postingan extends Model
{
    use HasFactory;

    protected $table = 'postingan'; // Nama tabel kustom

    protected $fillable = [
        'user_id',
        'tipe',
        'nama_barang',
        'kategori',
        'lokasi',
        'waktu_kejadian',
        'deskripsi',
        'foto',
        'status',
    ];

    // Relasi ke User (Pembuat Postingan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class, 'postingan_id');
    }

    // Relasi ke Laporan fiktif
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'postingan_id');
    }
}