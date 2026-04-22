<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Postingan extends Model
{
    protected $fillable = ['id_pelapor','namaBarang','kategori','lokasi','deskripsi','foto','namaKontak','noKontak','status','jenis'];
    /** @use HasFactory<\Database\Factories\PostinganFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_postingan');
    }
}
