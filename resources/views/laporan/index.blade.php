<x-app-layout>
    <x-slot:title>Laporan Saya — Balik.in</x-slot>

    <div style="max-width:860px;margin:0 auto">
        <div class="bk-page-header" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem">
            <div>
                <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger);margin-bottom:0.35rem">
                    Akun Saya
                </div>
                <h1 class="bk-page-header__title">Laporan Saya</h1>
                <p class="bk-page-header__sub">Daftar postingan yang pernah Anda laporkan sebagai fiktif.</p>
            </div>
            <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost" style="font-size:0.82rem">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2rem">
            @php
                $totalLaporan = $laporan->count();
                $pending = $laporan->where('status_laporan', 'pending')->count();
                $selesai = $laporan->where('status_laporan', 'selesai')->count();
            @endphp
            <div class="bk-card" style="padding:1.25rem 1.5rem;border-radius:var(--radius-md)">
                <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.4rem">Total Laporan</div>
                <div style="font-size:2rem;font-weight:800;color:var(--ink);letter-spacing:-0.03em">{{ $totalLaporan }}</div>
            </div>
            <div class="bk-card" style="padding:1.25rem 1.5rem;border-radius:var(--radius-md)">
                <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.4rem">Menunggu</div>
                <div style="font-size:2rem;font-weight:800;color:#854d0e;letter-spacing:-0.03em">{{ $pending }}</div>
            </div>
            <div class="bk-card" style="padding:1.25rem 1.5rem;border-radius:var(--radius-md)">
                <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:0.4rem">Selesai</div>
                <div style="font-size:2rem;font-weight:800;color:var(--success);letter-spacing:-0.03em">{{ $selesai }}</div>
            </div>
        </div>

        {{-- Laporan List --}}
        <div class="bk-card" style="overflow:hidden">
            @forelse($laporan as $lap)
                <div style="padding:1.5rem;border-bottom:1px solid var(--border-subtle);display:flex;gap:1.25rem;align-items:flex-start;transition:background 0.15s"
                    onmouseover="this.style.background='var(--surface-2)'"
                    onmouseout="this.style.background=''">

                    {{-- Status icon --}}
                    <div style="flex-shrink:0;margin-top:0.15rem">
                        @if($lap->status_laporan === 'pending')
                            <div style="width:36px;height:36px;border-radius:var(--radius-full);background:#fef9c3;display:flex;align-items:center;justify-content:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#854d0e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </div>
                        @elseif($lap->status_laporan === 'diproses')
                            <div style="width:36px;height:36px;border-radius:var(--radius-full);background:#dbeafe;display:flex;align-items:center;justify-content:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1 .64-8.64"/>
                                </svg>
                            </div>
                        @else
                            <div style="width:36px;height:36px;border-radius:var(--radius-full);background:var(--success-light);display:flex;align-items:center;justify-content:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:0.5rem;margin-bottom:0.5rem">
                            <div>
                                @if($lap->postingan)
                                    <a href="{{ route('postingan.show', $lap->postingan->id) }}"
                                        style="font-weight:700;font-size:1rem;color:var(--ink);text-decoration:none;transition:color 0.15s"
                                        onmouseover="this.style.color='var(--accent-dark)'"
                                        onmouseout="this.style.color='var(--ink)'">
                                        {{ $lap->postingan->nama_barang }}
                                    </a>
                                    <div style="font-size:0.78rem;color:var(--ink-faint);margin-top:2px">
                                        oleh <strong style="color:var(--ink-muted)">{{ $lap->postingan->user->name ?? 'N/A' }}</strong>
                                        &middot;
                                        <span class="bk-badge {{ $lap->postingan->tipe === 'hilang' ? 'bk-badge--hilang' : 'bk-badge--ditemukan' }}">
                                            {{ $lap->postingan->tipe }}
                                        </span>
                                    </div>
                                @else
                                    <span style="font-weight:700;font-size:1rem;color:var(--ink-faint);text-decoration:line-through">
                                        Postingan telah dihapus
                                    </span>
                                    <div style="font-size:0.75rem;color:var(--danger);margin-top:2px">
                                        Postingan ini sudah dihapus oleh admin.
                                    </div>
                                @endif
                            </div>
                            <div>
                                @if($lap->status_laporan === 'pending')
                                    <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:var(--radius-full);background:#fef9c3;color:#854d0e;border:1px solid #fde047">⏳ Menunggu</span>
                                @elseif($lap->status_laporan === 'diproses')
                                    <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:var(--radius-full);background:#dbeafe;color:#1e40af;border:1px solid #93c5fd">🔄 Diproses</span>
                                @else
                                    <span style="font-size:0.72rem;font-weight:700;padding:3px 10px;border-radius:var(--radius-full);background:var(--success-light);color:var(--success);border:1px solid #86efac">✅ Selesai</span>
                                @endif
                            </div>
                        </div>

                        {{-- Alasan --}}
                        <div style="background:var(--surface-2);border-radius:var(--radius-sm);padding:0.625rem 0.875rem;margin-top:0.5rem">
                            <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.25rem">Alasan Laporan</div>
                            <p style="font-size:0.85rem;color:var(--ink-muted);line-height:1.55">{{ $lap->alasan }}</p>
                        </div>

                        {{-- Metadata --}}
                        <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:0.625rem">
                            <span style="font-size:0.75rem;color:var(--ink-faint);display:inline-flex;align-items:center;gap:0.3rem">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                Dilaporkan {{ \Carbon\Carbon::parse($lap->tanggal_laporan)->format('d M Y, H:i') }}
                            </span>
                            @if($lap->admin)
                                <span style="font-size:0.75rem;color:var(--ink-faint);display:inline-flex;align-items:center;gap:0.3rem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                    </svg>
                                    Ditangani oleh <strong>{{ $lap->admin->name }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding:4rem 1.5rem;text-align:center">
                    <div style="width:64px;height:64px;border-radius:var(--radius-full);background:var(--surface-2);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <p style="font-weight:600;font-size:0.95rem;color:var(--ink-muted);margin-bottom:0.35rem">Belum ada laporan</p>
                    <p style="font-size:0.82rem;color:var(--ink-faint)">Anda belum pernah melaporkan postingan apapun.</p>
                    <a href="{{ route('beranda') }}" class="bk-btn bk-btn--ghost" style="margin-top:1.25rem;font-size:0.82rem">Jelajahi Postingan</a>
                </div>
            @endforelse
        </div>

        @if($laporan->count() > 0)
            <p style="font-size:0.78rem;color:var(--ink-faint);margin-top:1rem;text-align:center">
                Total {{ $laporan->count() }} laporan dikirim
            </p>
        @endif
    </div>
</x-app-layout>
