@props(['post'])

<div class="bk-card" style="display:flex;flex-direction:column">
    {{-- Foto --}}
    <div style="position:relative;overflow:hidden;flex-shrink:0">
        @if($post->foto)
            <img style="width:100%;height:180px;object-fit:cover;display:block" src="{{ asset('storage/'.$post->foto) }}" alt="{{ $post->nama_barang }}">
        @else
            <div style="width:100%;height:180px;background:var(--surface-2);display:flex;align-items:center;justify-content:center">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--surface-3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
        @endif
        <span style="position:absolute;top:10px;left:10px" class="bk-badge {{ $post->tipe == 'hilang' ? 'bk-badge--hilang' : 'bk-badge--ditemukan' }}">
            {{ $post->tipe }}
        </span>
        @if($post->status === 'selesai')
            <div style="position:absolute;inset:0;background:rgba(15,14,13,0.45);display:flex;align-items:center;justify-content:center">
                <span style="background:white;color:var(--ink-muted);font-size:0.7rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;padding:4px 10px;border-radius:var(--radius-full)">Selesai</span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div style="padding:1rem;flex:1;display:flex;flex-direction:column;gap:0.5rem">
        <div style="font-size:0.68rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--accent)">{{ $post->kategori }}</div>
        <a href="{{ route('postingan.show', $post->id) }}" style="font-size:1rem;font-weight:700;color:var(--ink);letter-spacing:-0.01em;line-height:1.3;display:block">
            {{ $post->nama_barang }}
        </a>
        <p style="font-size:0.8rem;color:var(--ink-muted);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;flex:1">{{ $post->deskripsi }}</p>

        <div style="display:flex;align-items:center;gap:0.3rem;font-size:0.75rem;color:var(--ink-faint);margin-top:auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $post->lokasi }}
        </div>

        {{-- Footer --}}
        <div style="padding-top:0.875rem;border-top:1px solid var(--border-subtle);display:flex;justify-content:space-between;align-items:center;gap:0.5rem;margin-top:0.25rem">
            <span style="font-size:0.72rem;color:var(--ink-faint)">{{ $post->created_at->diffForHumans() }}</span>

            <div style="display:flex;align-items:center;gap:0.4rem">
                {{-- Tombol Hubungi (hanya jika sudah login dan bukan pemilik) --}}
                @auth
                    @if(Auth::id() !== $post->user_id && $post->status !== 'selesai')
                        <button
                            onclick="openChatWith({{ $post->user_id }}, '{{ addslashes($post->user->name) }}', '{{ addslashes($post->nama_barang) }}')"
                            title="Hubungi {{ $post->user->name }}"
                            style="width:30px;height:30px;border-radius:var(--radius-full);background:var(--accent-light);border:1px solid rgba(200,146,42,0.3);color:var(--accent-dark);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.15s;flex-shrink:0"
                            onmouseover="this.style.background='var(--accent)';this.style.color='white'"
                            onmouseout="this.style.background='var(--accent-light)';this.style.color='var(--accent-dark)'"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </button>
                    @endif
                @endauth

                <a href="{{ route('postingan.show', $post->id) }}" style="font-size:0.78rem;font-weight:600;color:var(--accent);display:flex;align-items:center;gap:0.2rem">
                    Detail
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
