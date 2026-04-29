<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Postingan extends Model
{
    /** @use HasFactory<\Database\Factories\PostinganFactory> */
    use HasFactory;

    protected $table = 'postingan';

    protected $fillable = [
        'id_pelapor',
        'namaBarang',
        'kategori',
        'lokasi',
        'deskripsi',
        'foto',
        'namaKontak',
        'noKontak',
        'status',
        'jenis',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'jenis'  => 'string',
        ];
    }

    // ─── Scopes ───────────────────────────────────────────────────────────

    public function scopeHilang($query)
    {
        return $query->where('jenis', 'barangHilang');
    }

    public function scopeDitemukan($query)
    {
        return $query->where('jenis', 'barangDitemukan');
    }

    // ─── Relationships ────────────────────────────────────────────────────

    /**
     * Pelapor yang membuat postingan ini.
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelapor');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_postingan');
    }
}
