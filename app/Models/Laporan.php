<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanFactory> */
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'id_pelapor',
        'id_postingan',
        'alasan',
    ];

    // ─── Relationships ────────────────────────────────────────────────────

    /**
     * User yang membuat laporan ini.
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelapor');
    }

    /**
     * Postingan yang dilaporkan.
     */
    public function postingan(): BelongsTo
    {
        return $this->belongsTo(Postingan::class, 'id_postingan');
    }
}
