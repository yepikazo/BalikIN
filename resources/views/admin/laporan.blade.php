<x-admin-layout title="Kelola Laporan">

    <div style="margin-bottom:0.5rem">
        <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--danger)">Administrator</span>
    </div>
    <h1 style="font-size:1.75rem;font-weight:800;letter-spacing:-0.03em;color:var(--ink);margin-bottom:0.35rem">Kelola Laporan</h1>
    <p style="font-size:0.9rem;color:var(--ink-muted);margin-bottom:2rem">Tinjau dan kelola postingan yang dilaporkan oleh pengguna.</p>

    <div class="bk-card" style="overflow:hidden">
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem">
                <thead>
                    <tr style="background:var(--surface-2);border-bottom:1px solid var(--border)">
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Pelapor</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Barang Dilaporkan</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);min-width:200px">Alasan</th>
                        <th style="padding:0.875rem 1.25rem;text-align:left;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Status</th>
                        <th style="padding:0.875rem 1.25rem;text-align:center;font-size:0.68rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--ink-faint);white-space:nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $lap)
                        <tr style="border-bottom:1px solid var(--border-subtle);transition:background 0.1s"
                            onmouseover="this.style.background='var(--surface-2)'"
                            onmouseout="this.style.background=''">

                            {{-- Pelapor --}}
                            <td style="padding:1rem 1.25rem">
                                <div style="display:flex;align-items:center;gap:0.6rem">
                                    <div style="width:32px;height:32px;border-radius:var(--radius-full);background:var(--surface-3);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;flex-shrink:0">
                                        {{ strtoupper(substr($lap->pelapor->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:600;color:var(--ink)">{{ $lap->pelapor->name ?? 'N/A' }}</div>
                                        <div style="font-size:0.75rem;color:var(--ink-faint)">
                                            {{ \Carbon\Carbon::parse($lap->tanggal_laporan)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Barang --}}
                            <td style="padding:1rem 1.25rem">
                                @if($lap->postingan)
                                    <a href="{{ route('postingan.show', $lap->postingan->id) }}" target="_blank"
                                       style="font-weight:600;color:var(--accent-dark);text-decoration:none"
                                       onmouseover="this.style.textDecoration='underline'"
                                       onmouseout="this.style.textDecoration='none'">
                                        {{ $lap->postingan->nama_barang }}
                                    </a>
                                    <div style="font-size:0.75rem;color:var(--ink-faint);margin-top:2px">
                                        oleh {{ $lap->postingan->user->name }}
                                    </div>
                                    <span class="bk-badge bk-badge--{{ $lap->postingan->tipe }}"
                                          style="margin-top:4px;display:inline-block">{{ $lap->postingan->tipe }}</span>
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
                                @if($lap->status_laporan == 'pending')
                                    <span class="bk-badge" style="background:#fef9c3;color:#854d0e">⏳ Pending</span>
                                @elseif($lap->status_laporan == 'disetujui')
                                    <span class="bk-badge" style="background:#dbeafe;color:#1e40af">✅ Disetujui</span>
                                @elseif($lap->status_laporan == 'tolak')
                                    <span class="bk-badge" style="background:var(--danger-light);color:var(--danger)">❌ Tolak</span>
                                @else
                                    <span class="bk-badge" style="background:var(--surface-3);color:var(--ink-faint)">—</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:1rem 1.25rem;text-align:center">
                                @if($lap->postingan && $lap->status_laporan == 'pending')
                                    <div style="display:flex;gap:0.5rem;justify-content:center;align-items:center">
                                        <form action="{{ route('admin.laporan.update', $lap->id) }}" method="POST"
                                              onsubmit="return confirm('Tolak laporan ini?')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status_laporan" value="tolak">
                                            <button type="submit" class="bk-btn bk-btn--ghost"
                                                    style="font-size:0.78rem;padding:0.35rem 0.875rem;border:1px solid var(--border)">
                                                Tolak
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.laporan.update', $lap->id) }}" method="POST"
                                              onsubmit="return confirm('Setujui laporan ini dan suspend postingan secara otomatis?')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status_laporan" value="disetujui">
                                            <input type="hidden" name="tipe" value="suspend">
                                            <button type="submit" class="bk-btn bk-btn--danger"
                                                    style="font-size:0.78rem;padding:0.35rem 0.875rem;display:flex;align-items:center;gap:0.3rem">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                                </svg>
                                                Setujui & Suspend
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span style="font-size:0.78rem;color:var(--ink-faint);font-style:italic">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:4rem 1.5rem;text-align:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                                     stroke="var(--surface-3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                     style="margin:0 auto 1rem;display:block">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <p style="color:var(--ink-muted);font-size:0.95rem;font-weight:500">Semua bersih!</p>
                                <p style="color:var(--ink-faint);font-size:0.82rem;margin-top:0.3rem">Belum ada laporan fiktif saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
