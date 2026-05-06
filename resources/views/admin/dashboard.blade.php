<x-app-layout>
    <x-slot:title>Dashboard Admin — Balik.in</x-slot>

    <div class="bk-page-header" style="margin-bottom:2rem">
        <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger);margin-bottom:0.4rem">Administrator</div>
        <h1 class="bk-page-header__title">Panel Admin</h1>
        <p class="bk-page-header__sub">Ringkasan aktivitas dan manajemen aplikasi Balik.in</p>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem">
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--accent)">
            <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.5rem">Total Postingan</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--ink);line-height:1">{{ $totalPostingan }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">laporan aktif</div>
        </div>
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--success)">
            <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.5rem">Total Pengguna</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--ink);line-height:1">{{ $totalUser }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">pengguna terdaftar</div>
        </div>
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--accent-dark)">
            <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.5rem">Total Laporan</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--ink);line-height:1">{{ $totalLaporan }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">laporan masuk</div>
        </div>
        <div class="bk-card" style="padding:1.5rem;border-left:4px solid var(--danger)">
            <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--danger);margin-bottom:0.5rem">Perlu Ditinjau</div>
            <div style="font-size:2.25rem;font-weight:800;color:var(--danger);line-height:1">{{ $laporanPending }}</div>
            <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.4rem">laporan pending</div>
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="bk-card" style="padding:2rem">
        <h2 style="font-size:1rem;font-weight:700;color:var(--ink);margin-bottom:1.25rem;letter-spacing:-0.01em">Aksi Cepat</h2>
        <div style="display:flex;flex-wrap:wrap;gap:0.75rem">
            <a href="{{ route('admin.laporan') }}" class="bk-btn bk-btn--danger" style="gap:0.5rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Tinjau Laporan Fiktif
                @if($laporanPending > 0)
                    <span style="background:white;color:var(--danger);border-radius:var(--radius-full);font-size:0.7rem;font-weight:700;padding:1px 7px;min-width:20px;text-align:center">{{ $laporanPending }}</span>
                @endif
            </a>
            <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Lihat Beranda
            </a>
        </div>
    </div>

    {{-- Status info --}}
    @if($laporanPending > 0)
        <div class="bk-alert bk-alert--error" style="margin-top:1.25rem;display:flex;align-items:center;gap:0.5rem">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Ada <strong>{{ $laporanPending }} laporan pending</strong> yang belum ditinjau. Segera periksa.
        </div>
    @else
        <div class="bk-alert bk-alert--success" style="margin-top:1.25rem;display:flex;align-items:center;gap:0.5rem">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Semua laporan sudah ditangani. Tidak ada yang pending.
        </div>
    @endif

</x-app-layout>
