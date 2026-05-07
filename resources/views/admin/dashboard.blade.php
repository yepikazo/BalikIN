<x-admin-layout title="Dashboard">

    {{-- Stats Grid --}}
    <div style="margin-bottom:0.5rem">
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger)">Administrator</span>
    </div>
    <h1 style="font-size:1.75rem;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:0.35rem">Panel Admin</h1>
    <p style="font-size:0.9rem;color:var(--ink-muted);margin-bottom:2rem">Ringkasan aktivitas dan manajemen aplikasi Balik.in</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:1.25rem;margin-bottom:2rem">
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--accent)">
            <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.5rem">Total Postingan</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--ink);line-height:1">{{ $totalPostingan }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">postingan aktif</div>
        </div>
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--success)">
            <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.5rem">Total Pengguna</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--ink);line-height:1">{{ $totalUser }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">pengguna terdaftar</div>
        </div>
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--accent-dark)">
            <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.5rem">Total Laporan</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--ink);line-height:1">{{ $totalLaporan }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">laporan masuk</div>
        </div>
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--danger)">
            <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--danger);margin-bottom:0.5rem">Perlu Ditinjau</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--danger);line-height:1">{{ $laporanPending }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">laporan pending</div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bk-card" style="padding:2rem;margin-bottom:1.5rem">
        <h2 style="font-size:1rem;font-weight:700;color:var(--ink);margin-bottom:1.25rem;letter-spacing:-0.01em">Aksi Cepat</h2>
        <div style="display:flex;flex-wrap:wrap;gap:0.75rem">
            <a href="{{ route('admin.postingan.index') }}" class="bk-btn bk-btn--primary" style="gap:0.5rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Kelola Postingan
            </a>
            <a href="{{ route('admin.laporan') }}" class="bk-btn bk-btn--danger" style="gap:0.5rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                Tinjau Laporan Fiktif
                @if($laporanPending > 0)
                    <span style="background:white;color:var(--danger);border-radius:var(--radius-full);font-size:0.7rem;font-weight:700;padding:1px 7px;min-width:20px;text-align:center">{{ $laporanPending }}</span>
                @endif
            </a>
            <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Lihat Beranda
            </a>
        </div>
    </div>

    {{-- Status Alert --}}
    @if($laporanPending > 0)
        <div style="padding:1rem 1.25rem;background:var(--danger-light);border:1px solid #f5c0bc;border-radius:var(--radius-md);display:flex;align-items:center;gap:0.625rem;color:var(--danger)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            Ada <strong>{{ $laporanPending }} laporan pending</strong> yang belum ditinjau. Segera periksa.
        </div>
    @else
        <div style="padding:1rem 1.25rem;background:var(--success-light);border:1px solid #b7e0c5;border-radius:var(--radius-md);display:flex;align-items:center;gap:0.625rem;color:var(--success)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Semua laporan sudah ditangani. Tidak ada yang pending.
        </div>
    @endif

</x-admin-layout>
