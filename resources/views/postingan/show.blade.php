<x-app-layout>
    <x-slot:title>{{ $postingan->nama_barang }} — Balik.in</x-slot>

    <div style="max-width:880px;margin:0 auto">
        {{-- Breadcrumb --}}
        <a href="{{ route('beranda') }}"
            style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.82rem;color:var(--ink-muted);margin-bottom:1.5rem;transition:color 0.15s"
            onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='var(--ink-muted)'">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Kembali ke Beranda
        </a>

        <div class="bk-card" style="box-shadow:var(--shadow-md)">

            {{-- Header --}}
            <div style="padding:1.75rem 2rem;border-bottom:1px solid var(--border-subtle)">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem">
                    <div>
                        <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap;margin-bottom:0.875rem">
                            <span
                                class="bk-badge {{ $postingan->tipe == 'hilang' ? 'bk-badge--hilang' : 'bk-badge--ditemukan' }}">{{ $postingan->tipe }}</span>
                            <span
                                class="bk-badge {{ $postingan->status == 'aktif' ? 'bk-badge--aktif' : 'bk-badge--selesai' }}">{{ $postingan->status }}</span>
                        </div>
                        <h1
                            style="font-size:1.85rem;font-weight:800;letter-spacing:-0.03em;line-height:1.2;color:var(--ink)">
                            {{ $postingan->nama_barang }}</h1>
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;flex-wrap:wrap">
                            {{-- Avatar pelapor --}}
                            <div
                                style="width:24px;height:24px;border-radius:var(--radius-full);background:var(--ink);color:white;font-size:0.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                {{ strtoupper(substr($postingan->user->name, 0, 1)) }}
                            </div>
                            <span style="font-size:0.82rem;color:var(--ink-muted)">
                                <strong style="color:var(--ink)">{{ $postingan->user->name }}</strong>
                                &middot; {{ $postingan->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    @auth
                        @if (Auth::id() === $postingan->user_id || Auth::user()->is_admin)
                            <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                                <a href="{{ route('postingan.edit', $postingan->id) }}" class="bk-btn bk-btn--ghost"
                                    style="font-size:0.82rem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('postingan.destroy', $postingan->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus postingan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bk-btn bk-btn--danger" style="font-size:0.82rem">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Body --}}
            <div style="padding:1.75rem 2rem">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem" class="show-grid">

                    {{-- Foto --}}
                    <div>
                        @if ($postingan->foto)
                            <img src="{{ asset('storage/' . $postingan->foto) }}"
                                style="width:100%;border-radius:var(--radius-md);object-fit:cover;max-height:300px;border:1px solid var(--border-subtle);display:block"
                                alt="Foto {{ $postingan->nama_barang }}">
                        @else
                            <div
                                style="background:var(--surface-2);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;min-height:220px;border:1px dashed var(--border)">
                                <div style="text-align:center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                        viewBox="0 0 24 24" fill="none" stroke="var(--surface-3)" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 0.5rem">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <polyline points="21 15 16 10 5 21" />
                                    </svg>
                                    <p style="font-size:0.8rem;color:var(--ink-faint)">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div style="display:flex;flex-direction:column;gap:1.25rem">
                        {{-- Detail Grid --}}
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.875rem">
                            <div style="background:var(--surface-2);border-radius:var(--radius-md);padding:0.875rem">
                                <div
                                    style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.3rem">
                                    Kategori</div>
                                <div style="font-size:0.875rem;font-weight:600;color:var(--ink)">
                                    {{ $postingan->kategori }}</div>
                            </div>
                            <div style="background:var(--surface-2);border-radius:var(--radius-md);padding:0.875rem">
                                <div
                                    style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.3rem">
                                    Waktu</div>
                                <div style="font-size:0.875rem;font-weight:600;color:var(--ink)">
                                    {{ \Carbon\Carbon::parse($postingan->waktu_kejadian)->format('d M Y') }}</div>
                            </div>
                            <div
                                style="background:var(--surface-2);border-radius:var(--radius-md);padding:0.875rem;grid-column:1/-1">
                                <div
                                    style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.3rem">
                                    Lokasi</div>
                                <div
                                    style="font-size:0.875rem;font-weight:600;color:var(--ink);display:flex;align-items:center;gap:0.4rem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    {{ $postingan->lokasi }}
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <div
                                style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--ink-faint);margin-bottom:0.5rem">
                                Deskripsi</div>
                            <p style="font-size:0.875rem;color:var(--ink-muted);line-height:1.7;white-space:pre-line">
                                {{ $postingan->deskripsi }}</p>
                        </div>

                        {{-- ======================================
                             TOMBOL HUBUNGI PELAPOR
                        ====================================== --}}
                        @auth
                            @if (Auth::id() !== $postingan->user_id)
                                @if ($postingan->status === 'aktif')
                                    {{-- Tombol Utama Hubungi --}}
                                    <div
                                        style="background:linear-gradient(135deg,var(--accent-light),#fff8ee);border:1px solid rgba(200,146,42,0.25);border-radius:var(--radius-md);padding:1.25rem">
                                        <div style="display:flex;align-items:flex-start;gap:0.875rem">
                                            {{-- Avatar pelapor --}}
                                            <div
                                                style="width:44px;height:44px;border-radius:var(--radius-full);background:var(--accent);color:white;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px rgba(200,146,42,0.3)">
                                                {{ strtoupper(substr($postingan->user->name, 0, 1)) }}
                                            </div>
                                            <div style="flex:1">
                                                <div style="font-size:0.78rem;color:var(--ink-faint);margin-bottom:2px">
                                                    Pelapor</div>
                                                <div style="font-weight:700;color:var(--ink);font-size:0.95rem">
                                                    {{ $postingan->user->name }}</div>
                                                <div style="font-size:0.78rem;color:var(--ink-muted);margin-top:3px">
                                                    Bergabung {{ $postingan->user->created_at->format('M Y') }}
                                                </div>
                                            </div>
                                        </div>

                                        <button id="btn-hubungi"
                                            onclick="openChatWith({{ $postingan->user_id }}, '{{ addslashes($postingan->user->name) }}', '{{ addslashes($postingan->nama_barang) }}')"
                                            style="margin-top:1rem;width:100%;padding:0.7rem 1rem;background:var(--accent);color:white;border:none;border-radius:var(--radius-md);font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:all 0.2s;font-family:var(--font-body)"
                                            onmouseover="this.style.background='var(--accent-dark)';this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='var(--accent)';this.style.transform=''">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                            </svg>
                                            Hubungi {{ $postingan->user->name }}
                                        </button>

                                        <p
                                            style="font-size:0.75rem;color:var(--ink-faint);text-align:center;margin-top:0.625rem">
                                            Pesan akan langsung masuk ke chat
                                        </p>
                                    </div>
                                @else
                                    {{-- Status Selesai --}}
                                    <div
                                        style="background:var(--surface-2);border:1px solid var(--border);border-radius:var(--radius-md);padding:1.25rem;text-align:center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            style="margin:0 auto 0.5rem;display:block">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                        <p style="font-size:0.85rem;font-weight:600;color:var(--ink-muted)">Laporan ini
                                            sudah selesai</p>
                                        <p style="font-size:0.78rem;color:var(--ink-faint);margin-top:0.3rem">Barang sudah
                                            ditemukan / diserahkan.</p>
                                    </div>
                                @endif
                            @else
                                {{-- Pemilik sendiri --}}
                                <div
                                    style="background:var(--surface-2);border:1px dashed var(--border);border-radius:var(--radius-md);padding:1rem;text-align:center">
                                    <p style="font-size:0.82rem;color:var(--ink-muted)">Ini adalah postingan Anda sendiri.
                                    </p>
                                </div>
                            @endif
                        @else
                            {{-- Belum login --}}
                            <div
                                style="background:var(--accent-light);border:1px solid rgba(200,146,42,0.25);border-radius:var(--radius-md);padding:1.25rem;text-align:center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                    viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    style="margin:0 auto 0.75rem;display:block">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                </svg>
                                <p
                                    style="font-size:0.875rem;font-weight:600;color:var(--accent-dark);margin-bottom:0.5rem">
                                    Ingin menghubungi pelapor?</p>
                                <p style="font-size:0.8rem;color:var(--ink-muted);margin-bottom:0.875rem">Login untuk
                                    mengirim pesan langsung.</p>
                                <div style="display:flex;gap:0.5rem;justify-content:center">
                                    <a href="{{ route('login') }}" class="bk-btn bk-btn--accent"
                                        style="font-size:0.82rem">Masuk</a>
                                    <a href="{{ route('register') }}" class="bk-btn bk-btn--ghost"
                                        style="font-size:0.82rem">Daftar</a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- Laporan Section (hanya untuk user lain yang sudah login) --}}
            @auth
                @if (Auth::id() !== $postingan->user_id)
                    <div style="padding:1.25rem 2rem;border-top:1px solid var(--border-subtle);background:var(--surface)">
                        <details style="cursor:pointer">
                            <summary
                                style="font-size:0.78rem;color:var(--ink-faint);list-style:none;display:inline-flex;align-items:center;gap:0.4rem;user-select:none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                Laporkan postingan ini sebagai fiktif
                            </summary>
                            <form action="{{ route('laporan.store') }}" method="POST"
                                style="margin-top:0.875rem;display:flex;gap:0.5rem;flex-wrap:wrap">
                                @csrf
                                <input type="hidden" name="postingan_id" value="{{ $postingan->id }}">
                                <input type="text" name="alasan" placeholder="Jelaskan alasan laporan..."
                                    class="bk-input" style="flex:1;min-width:200px;font-size:0.82rem" required>
                                <button type="submit" class="bk-btn bk-btn--danger"
                                    style="white-space:nowrap;font-size:0.82rem">Kirim Laporan</button>
                            </form>
                        </details>
                    </div>
                @endif
            @endauth



        </div>
    </div>
</x-app-layout>

@push('scripts')
    <style>
        @media (max-width: 680px) {
            .show-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush

