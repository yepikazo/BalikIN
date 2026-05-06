@props(['post'])

<div class="bk-card">
    <div style="position:relative;overflow:hidden">
        @if($post->foto)
            <img style="width:100%;height:200px;object-fit:cover;display:block" src="{{ asset('storage/'.$post->foto) }}" alt="{{ $post->nama_barang }}">
        @else
            <div style="width:100%;height:200px;background:var(--surface-2);display:flex;align-items:center;justify-content:center">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--ink-faint)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
        @endif
        <span style="position:absolute;top:10px;right:10px" class="bk-badge {{ $post->tipe == 'hilang' ? 'bk-badge--hilang' : 'bk-badge--ditemukan' }}">
            {{ $post->tipe }}
        </span>
    </div>

    <div style="padding:1rem">
        <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--accent);margin-bottom:0.3rem">{{ $post->kategori }}</div>
        <a href="{{ route('postingan.show', $post->id) }}" style="display:block;font-family:var(--font-display);font-size:1.1rem;color:var(--ink);letter-spacing:-0.01em;line-height:1.3;margin-bottom:0.5rem">
            {{ $post->nama_barang }}
        </a>
        <p style="font-size:0.82rem;color:var(--ink-muted);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $post->deskripsi }}</p>

        <div style="margin-top:0.875rem;display:flex;align-items:center;gap:0.3rem;font-size:0.78rem;color:var(--ink-faint)">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            {{ $post->lokasi }}
        </div>

        <div style="margin-top:0.875rem;padding-top:0.875rem;border-top:1px solid var(--border-subtle);display:flex;justify-content:space-between;align-items:center">
            <span style="font-size:0.75rem;color:var(--ink-faint)">{{ $post->created_at->diffForHumans() }}</span>
            <a href="{{ route('postingan.show', $post->id) }}" style="font-size:0.8rem;font-weight:600;color:var(--accent);display:flex;align-items:center;gap:0.25rem">
                Lihat Detail
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</div>
