<x-app-layout>
    <x-slot:title>{{ $postingan->nama_barang }} — Balik.in</x-slot>

    <div style="max-width:860px;margin:0 auto">
        <!-- Back link -->
        <a href="{{ route('beranda') }}" style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.82rem;color:var(--ink-muted);margin-bottom:1.5rem">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Beranda
        </a>

        <div class="bk-card" style="box-shadow:var(--shadow-md)">
            <!-- Header -->
            <div style="padding:1.75rem 2rem;border-bottom:1px solid var(--border-subtle)">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem">
                    <div>
                        <span class="bk-badge {{ $postingan->tipe == 'hilang' ? 'bk-badge--hilang' : 'bk-badge--ditemukan' }}">{{ $postingan->tipe }}</span>
                        <h1 style="font-family:var(--font-display);font-size:1.8rem;letter-spacing:-0.02em;margin-top:0.75rem;line-height:1.2">{{ $postingan->nama_barang }}</h1>
                        <p style="font-size:0.82rem;color:var(--ink-faint);margin-top:0.4rem">
                            Diposting oleh <strong style="color:var(--ink-muted)">{{ $postingan->user->name }}</strong>
                            &middot; {{ $postingan->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    @auth
                        @if(Auth::id() === $postingan->user_id || Auth::user()->is_admin)
                            <div style="display:flex;gap:0.5rem">
                                <a href="{{ route('postingan.edit', $postingan->id) }}" class="bk-btn bk-btn--ghost" style="font-size:0.82rem">Edit</a>
                                <form action="{{ route('postingan.destroy', $postingan->id) }}" method="POST" onsubmit="return confirm('Hapus postingan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bk-btn bk-btn--danger" style="font-size:0.82rem">Hapus</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Body -->
            <div style="padding:1.75rem 2rem;display:grid;grid-template-columns:1fr 1fr;gap:2rem">
                @if($postingan->foto)
                    <img src="{{ asset('storage/'.$postingan->foto) }}" style="width:100%;border-radius:var(--radius-md);object-fit:cover;max-height:280px;border:1px solid var(--border-subtle)" alt="Foto Barang">
                @else
                    <div style="background:var(--surface-2);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;min-height:200px;border:1px dashed var(--border)">
                        <span style="color:var(--ink-faint);font-size:0.85rem">Tidak ada foto</span>
                    </div>
                @endif

                <div>
                    <h3 style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-muted);margin-bottom:1rem">Detail Barang</h3>
                    <div style="display:flex;flex-direction:column;gap:0.75rem">
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--ink-faint);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px">Kategori</div>
                            <div style="font-size:0.9rem;font-weight:500">{{ $postingan->kategori }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--ink-faint);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px">Lokasi Kejadian</div>
                            <div style="font-size:0.9rem;font-weight:500">{{ $postingan->lokasi }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--ink-faint);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px">Waktu Kejadian</div>
                            <div style="font-size:0.9rem;font-weight:500">{{ \Carbon\Carbon::parse($postingan->waktu_kejadian)->format('d M Y, H:i') }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;color:var(--ink-faint);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px">Status</div>
                            <span class="bk-badge {{ $postingan->status == 'aktif' ? 'bk-badge--aktif' : 'bk-badge--selesai' }}">{{ $postingan->status }}</span>
                        </div>
                    </div>

                    <div style="margin-top:1.25rem">
                        <h3 style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink-muted);margin-bottom:0.5rem">Deskripsi</h3>
                        <p style="font-size:0.875rem;color:var(--ink-muted);line-height:1.6;white-space:pre-line">{{ $postingan->deskripsi }}</p>
                    </div>

                    {{-- Mention to Chat button --}}
                    @auth
                        @if(Auth::id() !== $postingan->user_id)
                            <div style="margin-top:1.5rem;padding:1rem;background:var(--surface-2);border-radius:var(--radius-md);border:1px solid var(--border-subtle)">
                                <p style="font-size:0.8rem;color:var(--ink-muted);margin-bottom:0.75rem;font-weight:500">
                                    Punya informasi atau ingin menghubungi pelapor?
                                </p>
                                <button
                                    onclick="openChatWith({{ $postingan->user_id }}, '{{ addslashes($postingan->user->name) }}')"
                                    class="bk-mention-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    Hubungi {{ $postingan->user->name }}
                                </button>
                            </div>
                        @endif
                    @else
                        <div style="margin-top:1.5rem;padding:1rem;background:var(--accent-light);border-radius:var(--radius-md);border:1px solid rgba(200,146,42,0.3)">
                            <p style="font-size:0.82rem;color:var(--accent-dark)">
                                <a href="{{ route('login') }}" style="font-weight:700;text-decoration:underline">Masuk</a> atau
                                <a href="{{ route('register') }}" style="font-weight:700;text-decoration:underline">Daftar</a>
                                untuk menghubungi pelapor secara langsung.
                            </p>
                        </div>
                    @endauth
                </div>
            </div>

            @auth
                @if(Auth::id() !== $postingan->user_id)
                <!-- Report Section -->
                <div style="padding:1.25rem 2rem;border-top:1px solid var(--border-subtle);background:var(--surface)">
                    <details style="cursor:pointer">
                        <summary style="font-size:0.8rem;color:var(--ink-faint);list-style:none;display:flex;align-items:center;gap:0.4rem">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Laporkan postingan ini
                        </summary>
                        <form action="{{ route('laporan.store') }}" method="POST" style="margin-top:0.75rem;display:flex;gap:0.5rem">
                            @csrf
                            <input type="hidden" name="postingan_id" value="{{ $postingan->id }}">
                            <input type="text" name="alasan" placeholder="Alasan laporan..." class="bk-input" style="font-size:0.82rem" required>
                            <button type="submit" class="bk-btn bk-btn--danger" style="white-space:nowrap;font-size:0.82rem">Kirim Laporan</button>
                        </form>
                    </details>
                </div>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
function openChatWith(userId, userName) {
    window.dispatchEvent(new CustomEvent('open-chat-with', {
        detail: { userId, userName }
    }));
}
</script>
<style>
@media (max-width: 640px) {
    .bk-card > div:nth-child(2) { grid-template-columns: 1fr !important; }
    .bk-card > div:first-child { padding: 1.25rem !important; }
}
</style>
@endpush
