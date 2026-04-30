<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'laporan'; // Nama tabel kustom

    protected $fillable = [
        'pelapor_id',
        'postingan_id',
        'admin_id',
        'alasan',
        'tanggal_laporan',
        'status_laporan',
    ];

    // User yang melaporkan
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    // Postingan yang dilaporkan
    public function postingan()
    {
        return $this->belongsTo(Postingan::class, 'postingan_id');
    }

    // Admin yang memproses (jika sudah ada)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}