<x-app-layout>
    <x-slot:title>Kelola Laporan — Balik.in</x-slot>

    <div class="bk-page-header" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;margin-bottom:2rem">
        <div>
            <div style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger);margin-bottom:0.4rem">Administrator</div>
            <h1 class="bk-page-header__title">Laporan Postingan Fiktif</h1>
            <p class="bk-page-header__sub">Tinjau dan kelola postingan yang dilaporkan oleh pengguna.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bk-btn bk-btn--ghost">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Dashboard
        </a>
    </div>

    <div class="bk-card" style="overflow:hidden">
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem">
                <thead>
                    <tr style="background:var(--surface-2);border-bottom:1px solid var(--border)">
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Pelapor</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Barang Dilaporkan</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);min-width:200px">Alasan</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Status</th>
                        <th style="padding:0.875rem 1.25rem;text-align:center;font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $lap)
                        <tr style="border-bottom:1px solid var(--border-subtle);transition:background 0.1s" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background=''">
                            {{-- Pelapor --}}
                            <td style="padding:1rem 1.25rem">
                                <div style="display:flex;align-items:center;gap:0.6rem">
                                    <div style="width:32px;height:32px;border-radius:var(--radius-full);background:var(--surface-3);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;flex-shrink:0">
                                        {{ strtoupper(substr($lap->pelapor->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;color:var(--ink)">{{ $lap->pelapor->name ?? 'N/A' }}</div>
                                        <div style="font-size:0.75rem;color:var(--ink-faint)">{{ \Carbon\Carbon::parse($lap->tanggal_laporan)->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Barang --}}
                            <td style="padding:1rem 1.25rem">
                                @if($lap->postingan)
                                    <a href="{{ route('postingan.show', $lap->postingan->id) }}" target="_blank" style="font-weight:600;color:var(--accent-dark);text-decoration:none" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                        {{ $lap->postingan->nama_barang }}
                                    </a>
                                    <div style="font-size:0.75rem;color:var(--ink-faint);margin-top:2px">
                                        oleh {{ $lap->postingan->user->name }}
                                    </div>
                                    <span class="bk-badge bk-badge--{{ $lap->postingan->tipe }}" style="margin-top:4px;display:inline-block">{{ $lap->postingan->tipe }}</span>
                                @else
                                    <span style="color:var(--danger);font-size:0.82rem;font-style:italic;text-decoration:line-through">Postingan dihapus</span>
                                @endif
                            </td>

                            {{-- Alasan --}}
                            <td style="padding:1rem 1.25rem;color:var(--ink-muted);line-height:1.5">
                                {{ $lap->alasan }}
                            </td>

                            {{-- Status --}}
                            <td style="padding:1rem 1.25rem">
                                <form action="{{ route('admin.laporan.update', $lap->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status_laporan" onchange="this.form.submit()" style="
                                        font-size:0.75rem;font-weight:700;padding:0.3rem 0.6rem;border-radius:var(--radius-full);border:1px solid;cursor:pointer;outline:none;
                                        {{ $lap->status_laporan == 'pending' ? 'background:#fef9c3;color:#854d0e;border-color:#fde047' : '' }}
                                        {{ $lap->status_laporan == 'diproses' ? 'background:#dbeafe;color:#1e40af;border-color:#93c5fd' : '' }}
                                        {{ $lap->status_laporan == 'selesai' ? 'background:var(--success-light);color:var(--success);border-color:#86efac' : '' }}
                                    ">
                                        <option value="pending" {{ $lap->status_laporan == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="diproses" {{ $lap->status_laporan == 'diproses' ? 'selected' : '' }}>🔄 Diproses</option>
                                        <option value="selesai" {{ $lap->status_laporan == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                    </select>
                                </form>
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:1rem 1.25rem;text-align:center">
                                @if($lap->postingan)
                                    <form action="{{ route('admin.postingan.destroy', $lap->postingan->id) }}" method="POST" onsubmit="return confirm('Hapus postingan ini secara permanen? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bk-btn bk-btn--danger" style="font-size:0.78rem;padding:0.35rem 0.875rem">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size:0.78rem;color:var(--ink-faint);font-style:italic">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:4rem 1.5rem;text-align:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 1rem"><polyline points="20 6 9 17 4 12"/></svg>
                                <p style="color:var(--ink-muted);font-size:0.95rem;font-weight:500">Semua bersih!</p>
                                <p style="color:var(--ink-faint);font-size:0.82rem;margin-top:0.3rem">Belum ada laporan fiktif saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
